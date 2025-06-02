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
import { Project, ProjectUser, Task } from '@/types';
import ReportFormModal from './Actions/ReportFormModal.vue';
import ReportListModal from './Actions/ReportListModal.vue';
import EditModal from './Actions/EditModal.vue';

const props = defineProps<{
    task: Task
    projectUsers: ProjectUser[] | undefined
    project: Project
    currentProjectUser: ProjectUser
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
            <ReportFormModal :task="props.task"
                v-if="($page.props.auth.user.id === props.task.responsible.id) && (props.task.status === 'pending')">
                Отправить отчёт</ReportFormModal>
            <ReportListModal
                v-if="props.currentProjectUser.role === 'admin' || props.currentProjectUser.role === 'inspector'"
                :task="props.task" :reports="props.task.reports">Список отчётов</ReportListModal>
            <!-- </DropdownMenuItem> -->
            <!-- <DropdownMenuItem>Отправить отчёт</DropdownMenuItem> -->
            <EditModal v-if="props.currentProjectUser.role === 'admin' || props.currentProjectUser.role === 'moderator'"
                :task="props.task" :project-users="props.projectUsers">Редактировать</EditModal>
            <!-- <DropdownMenuItem>Редактировать</DropdownMenuItem> -->
            <!-- <DropdownMenuItem>Subscription</DropdownMenuItem> -->
        </DropdownMenuContent>
    </DropdownMenu>
</template>