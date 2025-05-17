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
import { Task } from '@/types';
import { DefineProps } from 'vue';
import ActionDropdown from './ActionDropdown.vue';

const props = defineProps<{
    tasks: Task[] | undefined
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
                        <div :class="item.status === 'pending' ? 'bg-yellow-400' : ''" class="w-2 h-2 rounded-full"></div>
                        {{ item.status }}
                    </div>
                </TableCell>
                <TableCell>{{ item.responsible.name }}</TableCell>
                <TableCell class="text-right">
                    <ActionDropdown :task="item" />
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>