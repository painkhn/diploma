<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'
import { Ellipsis } from 'lucide-vue-next';
import MoreModal from './Actions/MoreModal.vue';
import { ProjectUser, Task } from '@/types';
import ReportFormModal from './Actions/ReportFormModal.vue';
import ReportListModal from './Actions/ReportListModal.vue';
import EditModal from './Actions/EditModal.vue';

const props = defineProps<{
    task: Task
    projectUsers: ProjectUser[] | undefined
}>()
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger
            class="w-8 h-8 ml-auto flex items-center justify-center transition-all rounded-md hover:dark:bg-white/10">
            <Ellipsis />
        </DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuLabel>Действия</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <!-- <DropdownMenuItem> -->
            <MoreModal :task="props.task">Подробнее</MoreModal>
            <ReportFormModal :task="props.task">Отправить отчёт</ReportFormModal>
            <ReportListModal :task="props.task" :reports="props.task.reports">Список отчётов</ReportListModal>
            <!-- </DropdownMenuItem> -->
            <!-- <DropdownMenuItem>Отправить отчёт</DropdownMenuItem> -->
            <EditModal :task="props.task" :project-users="props.projectUsers">Редактировать</EditModal>
            <!-- <DropdownMenuItem>Редактировать</DropdownMenuItem> -->
            <!-- <DropdownMenuItem>Subscription</DropdownMenuItem> -->
        </DropdownMenuContent>
    </DropdownMenu>
</template>