<script setup lang="ts">
import { DonutChart } from '@/Components/ui/chart-donut'
import { generateColors } from '@/lib/colors';
import { ChartDataItem, Project, ProjectUser, Task } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    projectUsers: ProjectUser[] | undefined
    tasks: Task[] | undefined
    project: Project // Добавляем пропс проекта
}>()

// Подготавливаем данные для графика
const chartData = computed<ChartDataItem[]>(() => {
    if (!props.tasks || !props.project) return [];

    // Создаем массив всех пользователей
    const allUsers: (ProjectUser)[] = [
        ...(props.projectUsers || [])
    ];

    return allUsers
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
                    email: user.user.email,
                }
            };
        })
        .filter((user): user is ChartDataItem => user.total > 0);
});

// Цвета для графика
const colors = computed(() => {
    return generateColors(chartData.value.length);
});
</script>

<template>
    <div class="rounded-lg p-4 shadow max-[840px]:pt-0">
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