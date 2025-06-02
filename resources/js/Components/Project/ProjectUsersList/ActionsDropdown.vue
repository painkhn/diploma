<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'
import { Project, ProjectUser } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Ellipsis, Trash2, UserPen } from 'lucide-vue-next';
import DeleteUserConfirm from './DeleteUserConfirm.vue';
import EditRoleModal from './EditRoleModal.vue';

const props = defineProps<{
    currentProjectUser: ProjectUser
    projectUser: ProjectUser
    project: Project
}>()
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger>
            <Ellipsis />
        </DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuLabel>Действия для пользователя</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DeleteUserConfirm :project="props.project" :project-user="props.projectUser">
                <Trash2 class="size-5" />
                Удалить пользователя
            </DeleteUserConfirm>
            <EditRoleModal :project="props.project" :project-user="props.projectUser">
                <UserPen class="size-5" />
                Изменить роль
            </EditRoleModal>
            <!-- <DropdownMenuItem>Billing</DropdownMenuItem>
            <DropdownMenuItem>Team</DropdownMenuItem>
            <DropdownMenuItem>Subscription</DropdownMenuItem> -->
        </DropdownMenuContent>
    </DropdownMenu>
</template>