<script setup lang="ts">
import { ScrollArea } from '@/Components/ui/scroll-area'
import { Separator } from '@/Components/ui/separator'
import { Report, Task } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Check, X } from 'lucide-vue-next';

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
</script>

<template>
    <ScrollArea class="h-72 w-full rounded-md border">
        <div class="p-4">
            <h4 class="mb-4 text-sm font-medium leading-none">
                Отчёты
            </h4>

            <div v-for="(item, index) in props.reports" :key="index">
                <div class="flex items-center gap-x-4">
                    <button
                        class="text-sm w-full text-left line-clamp-1 p-2 rounded-md transition-all hover:dark:bg-white/10">
                        <!-- {{ tag }} -->
                        {{ item.content }}
                    </button>
                    <div class="flex items-center gap-x-2">
                        <button @click="confirm">
                            <Check class="text-green-400" />
                        </button>
                        <button @click="reject()">
                            <X class="text-red-400" />
                        </button>
                    </div>
                </div>
                <Separator class="my-2" />
            </div>
        </div>
    </ScrollArea>
</template>