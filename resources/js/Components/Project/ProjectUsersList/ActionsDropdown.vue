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
import { Ellipsis, Trash2 } from 'lucide-vue-next';
import DeleteUserConfirm from './DeleteUserConfirm.vue';

const props = defineProps<{
    currentProjectUser: ProjectUser
    projectUser: ProjectUser
    project: Project
}>()

// const deleteUser = async (userId: number) => {
//     try {
//         await axios.delete(route('project.user.delete', { id: userId }));
//         // После успешного удаления можно обновить список пользователей
//         location.reload(); // Перезагрузка страницы
//     } catch (error) {
//         console.error('Ошибка при удалении пользователя:', error);
//     }
// }
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
            <!-- <DropdownMenuItem>Billing</DropdownMenuItem>
            <DropdownMenuItem>Team</DropdownMenuItem>
            <DropdownMenuItem>Subscription</DropdownMenuItem> -->
        </DropdownMenuContent>
    </DropdownMenu>
</template>