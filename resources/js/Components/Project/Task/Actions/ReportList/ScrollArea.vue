<script setup lang="ts">
import { ScrollArea } from '@/Components/ui/scroll-area'
import { Separator } from '@/Components/ui/separator'
import { Report, Task } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Check, X } from 'lucide-vue-next';
import { utils, writeFile } from 'xlsx';

const tags = Array.from({ length: 50 }).map(
    (_, i, a) => `v1.2.0-beta.${a.length - i}`,
)

const props = defineProps<{
    reports: Report[] | undefined
    task: Task
}>()

const formConfirm = useForm({
    title: props.task.title,
    description: props.task.description,
    end_date: props.task.end_date,
    responsible_id: props.task.responsible_id,
    status: 'completed'
});

const formReject = useForm({
    title: props.task.title,
    description: props.task.description,
    end_date: props.task.end_date,
    responsible_id: props.task.responsible_id,
    status: 'pending'
});

const confirm = () => {
    formConfirm.patch(route('task.update', props.task.id), {
        onSuccess: () => {
            console.log('Статус изменён!');
            // Дополнительные действия после успеха
        }
    });
};

const reject = () => {
    formReject.patch(route('task.update', props.task.id), {
        onSuccess: () => {
            console.log('Статус изменён!');
            // Дополнительные действия после успеха
        }
    });
}

const downloadReport = (reportContent: string) => {
    const workbook = utils.book_new();

    // Подготавливаем данные с заголовками
    const data = [
        ["Поле", "Значение"],
        ["Задача", props.task.title],
        ["Статус", props.task.status],
        ["Дата создания", new Date(props.task.created_at).toLocaleDateString()],
        ["Дата окончания", new Date(props.task.end_date).toLocaleDateString()],
        ["Содержание отчета", reportContent]
    ];

    const worksheet = utils.aoa_to_sheet(data);

    // Функция для автоматического расчета ширины колонок
    const calculateColWidths = (data: any[][]) => {
        const colWidths = data[0].map((_, colIndex) => {
            // Находим максимальную длину текста в колонке
            const maxLength = data.reduce((acc, row) => {
                const cellValue = row[colIndex]?.toString() || '';
                return Math.max(acc, cellValue.length);
            }, 0);

            // Добавляем небольшой отступ (в символах)
            return { wch: Math.min(Math.max(maxLength + 2, 10), 50) }; // Минимум 10, максимум 50
        });
        return colWidths;
    };

    // Применяем автоматическую ширину колонок
    worksheet['!cols'] = calculateColWidths(data);

    utils.book_append_sheet(workbook, worksheet, "Отчет");

    writeFile(workbook, `Отчет_по_задаче_${props.task.title}.xlsx`);
};
</script>

<template>
    <ScrollArea class="h-72 w-full rounded-md border">
        <div class="p-4">
            <h4 class="mb-4 text-sm font-medium leading-none">
                Отчёты
            </h4>

            <div v-for="(item, index) in props.reports" :key="index">
                <div class="flex items-center gap-x-4">
                    <button @click="downloadReport(item.content)"
                        class="text-sm w-full text-left line-clamp-1 p-2 rounded-md transition-all hover:dark:bg-white/10">
                        <!-- {{ tag }} -->
                        {{ item.content }}
                    </button>
                    <div class="flex items-center gap-x-2">
                        <button @click="confirm">
                            <Check class="text-green-400 transition-all hover:text-green-500" />
                        </button>
                        <button @click="reject()">
                            <X class="text-red-400 transition-all hover:text-red-500" />
                        </button>
                    </div>
                </div>
                <Separator class="my-2" />
            </div>
        </div>
    </ScrollArea>
</template>