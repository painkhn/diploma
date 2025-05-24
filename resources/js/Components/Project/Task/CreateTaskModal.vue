<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'

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

const submit = () => {
    form.post(route('task.store', { id: props.project.id }), {
        onSuccess: () => {
            form.reset()
            console.log('нормас')
        },
        onError: () => {
            console.log('не нормас')
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
                </div>
                <div class="space-y-2">
                    <Label>Описание задачи</Label>
                    <Textarea type="text" v-model="form.description" />
                </div>
                <div class="space-y-2">
                    <Label>Дата окончания</Label>
                    <DatePicker type="text" v-model="form.end_date" />
                </div>
                <div class="space-y-2">
                    <Label>Ответственный пользователь</Label>
                    <ProjectUsers :auth-user="$page.props.auth.user" :project-users="props.projectUsers"
                        v-model="form.responsible_id" />
                </div>
                <Button type="submit"
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">Создать</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>