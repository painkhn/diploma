<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import Label from '@/Components/ui/label/Label.vue';
import { Project, ProjectUser } from '@/types';
import Button from '@/Components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import RoleSelect from './EditRole/RoleSelect.vue';
import Loader from '@/Components/Loader/Loader.vue';
import { useToast } from '@/Components/ui/toast/use-toast'

const { toast } = useToast()

const props = defineProps<{
    projectUser: ProjectUser
    project: Project
}>()

const form = useForm({
    role: ''
})

const isLoading = ref<boolean>(false)

const submit = () => {
    isLoading.value = true

    form.patch(route('project.user.role.update', {
        projectId: props.project.id,
        userId: props.projectUser.user.id
    }), {
        onSuccess: () => {
            form.reset()
            console.log('Роль пользователя проекта успешно изменена');
            toast({
                title: 'Успешно!',
                description: 'Роль пользователя проекта успешно изменена',
            })
        },
        onError: (errors) => {
            console.log('Ошибка при изменении роли пользователя проекта: ', errors);
        },
        onFinish: () => {
            isLoading.value = false
        }
    })
}

// onMounted(() => {
//     console.log('алёша', props.projectUser.user_id);
// })
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="text-sm flex items-center w-full gap-2 px-2 py-1.5 rounded transition-all hover:bg-black/10 hover:dark:bg-white/10">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Изменить роль {{ props.projectUser.user.name }}</DialogTitle>
                <DialogDescription>
                    Выберите новую роль и нажмите на кнопку "Изменить", чтобы изменить роль пользователя проекта.
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-1">
                    <Label>Выберите новую роль</Label>
                    <RoleSelect v-model="form.role" :project-user="props.projectUser" />
                </div>
                <Button type="submit" :disabled="isLoading"
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80 disabled:opacity-50">
                    <Loader v-if="isLoading" />
                    Изменить
                </Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>