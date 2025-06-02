<script setup lang="ts">
import Button from '@/Components/ui/button/Button.vue';
import Input from '@/Components/ui/input/Input.vue';
import Label from '@/Components/ui/label/Label.vue';
import { ScrollArea } from '@/Components/ui/scroll-area'
import { Separator } from '@/Components/ui/separator'
import Textarea from '@/Components/ui/textarea/Textarea.vue';
import { Report, Task } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Check, X } from 'lucide-vue-next';
import { utils, write } from 'xlsx';

import JSZip from 'jszip';
import { saveAs } from 'file-saver';
import RejectReportForm from './RejectReportForm.vue';

const tags = Array.from({ length: 50 }).map(
    (_, i, a) => `v1.2.0-beta.${a.length - i}`,
)

const props = defineProps<{
    backReports: Report[] | undefined
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
};

const downloadFullReport = async (report: Report) => {
    const zip = new JSZip();

    // 1. Создаем Excel файл
    const workbook = utils.book_new();
    const data = [
        ["Поле", "Значение"],
        ["Ответственный", report.user.name],
        ["Задача", props.task.title],
        ["Статус", props.task.status],
        ["Дата создания", new Date(props.task.created_at).toLocaleDateString()],
        ["Дата окончания", new Date(props.task.end_date).toLocaleDateString()],
        ["Содержание отчета", report.message]
    ];
    const worksheet = utils.aoa_to_sheet(data);
    utils.book_append_sheet(workbook, worksheet, "Отчет");

    // 2. Получаем buffer
    const excelBuffer = write(workbook, {
        bookType: 'xlsx',
        type: 'array',
    });

    // 3. Добавляем в ZIP
    zip.file(`Отчет_${props.task.title}.xlsx`, excelBuffer);

    // 4. Добавляем прикрепленный файл, если есть
    if (report.file_path) {
        try {
            const response = await fetch(`/storage/${report.file_path}`);
            if (response.ok) {
                const fileBlob = await response.blob();
                const fileName = report.file_path.split('/').pop();
                zip.file(fileName || 'attachment', fileBlob);
            }
        } catch (error) {
            console.error('Ошибка при загрузке файла:', error);
        }
    }

    // 5. Генерируем и скачиваем ZIP
    const content = await zip.generateAsync({ type: 'blob' });
    saveAs(content, `Полный_отчет_${props.task.title}.zip`);
};
</script>

<template>
    <ScrollArea class="h-72 w-full rounded-md border">
        <div class="p-4">
            <h4 class="mb-4 text-sm font-medium leading-none">
                Отчёты
            </h4>

            <div v-for="(item, index) in props.backReports" :key="index">
                <div class="flex items-center gap-x-4">
                    <button @click="downloadFullReport(item)"
                        class="text-sm w-full text-left line-clamp-1 p-2 rounded-md transition-all hover:dark:bg-white/10">
                        <!-- {{ tag }} -->
                        {{ item.user.name }}
                    </button>
                    <div class="flex items-center gap-x-2" v-if="item.type === 'complete'">
                        <button @click="confirm">
                            <Check class="text-green-400 transition-all hover:text-green-500" />
                        </button>
                        <RejectReportForm :task="props.task" @click="reject">
                            <X class="text-red-400 transition-all hover:text-red-500" />
                        </RejectReportForm>
                    </div>
                </div>
                <Separator class="my-2" />
            </div>
        </div>
    </ScrollArea>
</template>