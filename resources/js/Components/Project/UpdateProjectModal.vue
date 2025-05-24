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
import Input from '../ui/input/Input.vue';
import Label from '../ui/label/Label.vue';
import DatePicker from './CreateModal/DatePicker.vue';
import Button from '../ui/button/Button.vue';
import Textarea from '../ui/textarea/Textarea.vue';
import { Project } from '@/types';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps<{
    project: Project
}>()

const form = useForm({
    title: props.project.title,
    description: props.project.description,
    start_date: props.project.start_date,
    end_date: props.project.end_date
});

const submit = () => {
    form.patch(route('project.update', { project: props.project.id }), {
        onSuccess: () => {
            form.reset()
            console.log('успешно')
        },
        onError: () => {
            console.log('error')
        }
    })
}

const destroy = async () => {
    const response = await axios.delete(route('project.delete', {project: props.project.id}))
}
</script>

<template>
    <Dialog>
        <DialogTrigger class="transition-all hover:opacity-80">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Редактировать тему</DialogTitle>
                <DialogDescription>
                    Введите новые данные, чтобы редактировать тему.
                </DialogDescription>
            </DialogHeader>
            <form class="space-y-4" @submit.prevent="submit">
                <div class="space-y-2">
                    <Label>Название темы</Label>
                    <Input type="text" v-model="form.title" />
                </div>
                <div class="space-y-2">
                    <Label>Описание проекта</Label>
                    <Textarea type="text" v-model="form.description" />
                </div>
                <div class="gap-x-4 flex items-center">
                    <div class="space-y-2">
                        <Label>Дата начала проекта проекта</Label>
                        <DatePicker type="text" />
                    </div>
                    <div class="space-y-2">
                        <Label>Дата окончания проекта проекта</Label>
                        <DatePicker type="text" />
                    </div>
                </div>
                <Button type="submit" variant="default"
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">Сохранить</Button>
            </form>
            <span class="text-center">или</span>
            <form @submit.prevent="destroy">
                <Button
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80"
                    type="submit">Удалить проект</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>