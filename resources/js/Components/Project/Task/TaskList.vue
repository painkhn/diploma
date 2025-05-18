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
import { DefineProps } from 'vue';
import ActionDropdown from './ActionDropdown.vue';

const props = defineProps<{
    tasks: Task[] | undefined
    projectUsers: ProjectUser[] | undefined
    project: Project
}>()
</script>

<template>
    <h2 class="text-2xl font-semibold mb-4">Список задач</h2>
    <Table>
        <TableCaption></TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[150px]">
                    Название
                </TableHead>
                <TableHead>Статус</TableHead>
                <TableHead>Ответственный</TableHead>
                <TableHead class="text-right">

                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="(item, index) in (props.tasks as Task[])" :key="index">
                <TableCell class="font-medium">
                    {{ item.title }}
                </TableCell>
                <TableCell>
                    <div class="flex items-center gap-x-2">
                        <div v-if="item.status === 'pending'" :class="item.status === 'pending' ? 'bg-yellow-400' : ''" class="w-2 h-2 rounded-full"></div>
                        <div v-if="item.status === 'consideration'" :class="item.status === 'consideration' ? 'bg-blue-400' : ''" class="w-2 h-2 rounded-full"></div>
                        <div v-if="item.status === 'completed'" :class="item.status === 'completed' ? 'bg-green-400' : ''" class="w-2 h-2 rounded-full"></div>
                        <div v-if="item.status === 'canceled'" :class="item.status === 'canceled' ? 'bg-red-400' : ''" class="w-2 h-2 rounded-full"></div>
                        {{ item.status }}
                    </div>
                </TableCell>
                <TableCell>{{ item.responsible.name }}</TableCell>
                <TableCell class="text-right">
                    <ActionDropdown :project="props.project" :task="item" :project-users="props.projectUsers" />
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>