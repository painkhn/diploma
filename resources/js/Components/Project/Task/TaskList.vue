<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table'
import { Project, ProjectUser, Task } from '@/types';
import { ref, computed, watch } from 'vue';
import ActionDropdown from './ActionDropdown.vue';
import TaskSearch from '@/Components/Project/Search/TaskSearch.vue';
import TaskStatus from './TaskStatus.vue';
import TaskStatusSelect from '../Search/TaskStatusSelect.vue';
import TaskEndDateSelect from '../Search/TaskEndDateSelect.vue';
import TaskProgress from './TaskProgress.vue';

const props = defineProps<{
    tasks: Task[] | undefined
    projectUsers: ProjectUser[] | undefined
    project: Project
    currentProjectUser: ProjectUser
}>()

const searchQuery = ref('');
const selectedStatus = ref<string | null>(null);
const sortByDate = ref<string | null>(null);

// Для отладки можно добавить watch
watch(selectedStatus, (newVal) => {
    console.log('Selected status changed:', newVal);
});

const filteredTasks = computed(() => {
    if (!props.tasks) return [];

    let tasks = [...props.tasks];

    // Фильтрация по поиску
    tasks = tasks.filter(task => {
        const matchesSearch = task.title.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesStatus = selectedStatus.value ? task.status === selectedStatus.value : true;
        return matchesSearch && matchesStatus;
    });

    // Сортировка по дате
    if (sortByDate.value) {
        tasks.sort((a, b) => {
            const dateA = a.end_date ? new Date(a.end_date).getTime() : 0;
            const dateB = b.end_date ? new Date(b.end_date).getTime() : 0;

            if (sortByDate.value === 'asc') {
                return dateA - dateB; // Сначала те, у которых дата раньше
            } else {
                return dateB - dateA; // Сначала те, у которых дата позже
            }
        });
    }

    return tasks;
});

</script>

<template>
    <h2 class="text-2xl font-semibold mb-4">Список задач</h2>
    <!-- фильтрация, поиск, сортировка -->
    <div class="flex gap-2">
        <TaskSearch v-model="searchQuery" />
        <TaskStatusSelect v-model="selectedStatus" />
        <TaskEndDateSelect v-model="sortByDate" />
    </div>
    <!-- строка прогресса задач -->
    <div>
        <TaskProgress :tasks="props.tasks" />
    </div>
    <Table>
        <TableCaption></TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[150px]">
                    Название
                </TableHead>
                <TableHead class="w-[250px]">Статус</TableHead>
                <TableHead>Ответственный</TableHead>
                <TableHead class="text-right"></TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="(item, index) in filteredTasks" :key="index" v-if="filteredTasks.length > 0">
                <TableCell class="font-medium">
                    {{ item.title }}
                </TableCell>
                <TableCell>
                    <TaskStatus :task="item" />
                </TableCell>
                <TableCell>{{ item.responsible.name }}</TableCell>
                <TableCell class="text-right">
                    <ActionDropdown :current-project-user="props.currentProjectUser" :project="props.project"
                        :task="item" :project-users="props.projectUsers" />
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
    <div v-if="filteredTasks.length <= 0">
        <p class="w-full font-semibold text-sm opacity-80">Не найдено ни одной задачи</p>
    </div>
</template>