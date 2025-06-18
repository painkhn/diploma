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

import Input from '@/Components/ui/input/Input.vue';
import Label from '@/Components/ui/label/Label.vue';
import Button from '@/Components/ui/button/Button.vue';
import Textarea from '@/Components/ui/textarea/Textarea.vue';
import DatePicker from '@/Components/Project/CreateModal/DatePicker.vue';
import ProjectUsers from '@/Components/Project/Task/ProjectUsers.vue';
import { ref } from 'vue'

import { Project, User } from '@/types';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Loader from '@/Components/Loader/Loader.vue';
import { useToast } from '@/Components/ui/toast/use-toast'

const { toast } = useToast()

const form = useForm({
    title: '',
    description: '',
    end_date: '',
    responsible_id: ''
})

const props = defineProps<{
    project: Project,
    projectUsers: any
}>()

const isLoading = ref<boolean>(false)

const submit = () => {
    isLoading.value = true

    form.post(route('task.store', { id: props.project.id }), {
        onSuccess: () => {
            form.reset()
            console.log('нормас')
            toast({
                title: 'Успешно!',
                description: 'Новая задача была успешно добавлена',
            })
        },
        onError: () => {
            console.log('не нормас')
        },
        onFinish: () => {
            isLoading.value = false
        }
    })
}
</script>

<template>
    <Dialog>
        <DialogTrigger class="transition-all hover:opacity-80">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Создать задачу</DialogTitle>
                <DialogDescription>
                    Заполните форму, чтобы создать новую задачу.
                </DialogDescription>
            </DialogHeader>
            <form class="space-y-4" @submit.prevent="submit">
                <div class="space-y-2">
                    <Label>Название задачи</Label>
                    <Input type="text" v-model="form.title" />
                    <span v-if="form.errors.title" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.title }}
                    </span>
                </div>
                <div class="space-y-2">
                    <Label>Описание задачи</Label>
                    <Textarea type="text" v-model="form.description" />
                    <span v-if="form.errors.description" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.description }}
                    </span>
                </div>
                <div class="space-y-2">
                    <Label>Дата окончания</Label>
                    <DatePicker type="text" v-model="form.end_date" />
                    <span v-if="form.errors.end_date" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.end_date }}
                    </span>
                </div>
                <div class="space-y-2">
                    <Label>Ответственный пользователь</Label>
                    <ProjectUsers :auth-user="$page.props.auth.user" :project-users="props.projectUsers"
                        v-model="form.responsible_id" />
                    <span v-if="form.errors.responsible_id" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.responsible_id }}
                    </span>
                </div>
                <Button type="submit" :disabled="isLoading"
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80 disabled:opacity-80">
                    <Loader v-if="isLoading" />
                    Создать
                </Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>