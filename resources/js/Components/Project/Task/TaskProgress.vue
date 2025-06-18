<script setup lang="ts">
import { Progress } from '@/Components/ui/progress'
import { Task } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    tasks: Task[] | undefined
}>()

const progressValue = computed(() => {
    if (!props.tasks || props.tasks.length === 0) return 0;

    // Фильтруем задачи, исключая canceled
    const activeTasks = props.tasks.filter(task => task.status !== 'canceled');
    if (activeTasks.length === 0) return 0; // Если все задачи canceled или список пуст

    // Считаем выполненные среди активных
    const completedTasks = activeTasks.filter(task => task.status === 'completed');
    return Math.round((completedTasks.length / activeTasks.length) * 100);
});
</script>

<template>
    <div class="flex flex-col gap-2 my-4">
        <div class="flex justify-between text-sm">
            <span>Прогресс выполнения задач</span>
            <span>{{ progressValue }}%</span>
        </div>
        <Progress :model-value="progressValue" />
    </div>
</template>