<script setup lang="ts">
import { Progress } from '@/Components/ui/progress'
import { Task } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    tasks: Task[] | undefined
}>()

const progressValue = computed(() => {
    if (!props.tasks || props.tasks.length === 0) return 0;

    const completedTasks = props.tasks.filter(task => task.status === 'completed');
    return Math.round((completedTasks.length / props.tasks.length) * 100);
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