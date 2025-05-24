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
import { ref, computed } from 'vue';
import ActionDropdown from './ActionDropdown.vue';
import TaskSearch from '@/Components/Project/Search/TaskSearch.vue';

const props = defineProps<{
    tasks: Task[] | undefined
    projectUsers: ProjectUser[] | undefined
    project: Project
}>()

const searchQuery = ref('');

const filteredTasks = computed(() => {
    if (!props.tasks) return [];

    return props.tasks.filter(task =>
        task.title.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
</script>

<template>
    <h2 class="text-2xl font-semibold mb-4">Список задач</h2>
    <TaskSearch v-model="searchQuery" />
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
                    <div class="flex items-center gap-x-2">
                        <div v-if="item.status === 'pending'" :class="item.status === 'pending' ? 'bg-yellow-400' : ''"
                            class="w-2 h-2 rounded-full"></div>
                        <div v-if="item.status === 'consideration'"
                            :class="item.status === 'consideration' ? 'bg-blue-400' : ''" class="w-2 h-2 rounded-full">
                        </div>
                        <div v-if="item.status === 'completed'"
                            :class="item.status === 'completed' ? 'bg-green-400' : ''" class="w-2 h-2 rounded-full">
                        </div>
                        <div v-if="item.status === 'canceled'" :class="item.status === 'canceled' ? 'bg-red-400' : ''"
                            class="w-2 h-2 rounded-full"></div>
                        {{ item.status }}
                    </div>
                </TableCell>
                <TableCell>{{ item.responsible.name }}</TableCell>
                <TableCell class="text-right">
                    <ActionDropdown :project="props.project" :task="item" :project-users="props.projectUsers" />
                </TableCell>
            </TableRow>
            <!-- <TableRow v-else>
            </TableRow> -->
        </TableBody>
    </Table>
    <div v-if="filteredTasks.length <= 0">
        <p class="w-full font-semibold text-sm opacity-80">Не найдено ни одной задачи</p>
    </div>
</template>