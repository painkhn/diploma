<script setup lang="ts">
import { DonutChart } from '@/Components/ui/chart-donut'
import { generateColors } from '@/lib/colors';
import { ChartDataItem, ProjectUser, Task } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    projectUsers: ProjectUser[] | undefined
    tasks: Task[] | undefined
}>()

// Подготавливаем данные для графика
const chartData = computed<ChartDataItem[]>(() => {
    if (!props.projectUsers || !props.tasks) return [];

    return props.projectUsers
        .map(user => {
            const taskCount = props.tasks!.filter(task =>
                task.responsible_id === user.user_id
            ).length;

            return {
                name: user.user.name,
                total: taskCount,
                user: {
                    id: user.user.id,
                    name: user.user.name,
                    email: user.user.email
                }
            };
        })
        .filter((user): user is ChartDataItem => user.total > 0); // Type guard для фильтрации
});

// Цвета для графика
const colors = computed(() => {
    return generateColors(chartData.value.length);
});
</script>

<template>
    <div class="rounded-lg p-4 shadow">
        <h3 class="text-lg font-semibold mb-4 text-center">
            Распределение задач по пользователям
        </h3>
        <DonutChart index="name" category="total" :data="chartData" :type="'pie'" :colors="colors"
            :value-formatter="(value: number) => `${value} задач`" />

        <div v-if="chartData.length === 0" class="text-center py-4 text-gray-500">
            Нет данных для отображения
        </div>
    </div>
</template>