<script setup lang="ts">
import Button from '@/Components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { Project, ProjectUser } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps<{
    project: Project
    projectUser: ProjectUser
}>()

const btn = useForm({})

const deleteUser = () => {
    btn.delete(route('project.user.delete', {
        projectId: props.project.id,
        userId: props.projectUser.user.id
    }), {
        onSuccess: () => {
            // Лучше использовать Inertia.reload вместо location.reload
            // location.reload();
            console.log('успешно');
        },
        onError: (errors) => {
            console.error('Ошибка при удалении:', errors);
        }
    });
}
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="text-sm flex items-center gap-2 px-2 py-1.5 rounded transition-all hover:bg-black/10 hover:dark:bg-white/10">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Вы уверены?</DialogTitle>
                <DialogDescription>
                    Если вы уверены, что хотите удалить пользоватея, то нажмите кнопку ниже или закройте это окно, если
                    это не так.
                </DialogDescription>
            </DialogHeader>
            <form class="text-sm" @submit.prevent="deleteUser()">
                <Button type="submit"
                    class="bg-red-500 dark:bg-red-400 transition-all hover:bg-red-400 hover:dark:bg-red-300 text-white dark:text-black">Удалить
                    пользователя</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>