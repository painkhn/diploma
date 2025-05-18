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
import Textarea from '@/Components/ui/textarea/Textarea.vue';
import { ProjectUser, Task } from '@/types';

import { useForm } from '@inertiajs/vue3';
import DatePicker from '../../CreateModal/DatePicker.vue';
import ProjectUsers from '../ProjectUsers.vue';
import Button from '@/Components/ui/button/Button.vue';

const props = defineProps<{
    task: Task
    projectUsers: ProjectUser[] | undefined
}>()


const form = useForm({
    title: props.task.title,
    description: props.task.description,
    end_date: props.task.end_date,
    responsible_id: props.task.responsible_id,
    status: props.task.status
})

const submit = () => {
    form.patch(route('task.update', { task: props.task.id }), {
        onSuccess: () => {
            form.reset()
            console.log('успешно');
            location.reload();
        },
        onError: () => {
            console.log('error')
        }
    })
}
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="relative flex cursor-pointer w-full hover:dark:bg-white/10 select-none items-center rounded-sm gap-2 px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&>svg]:size-4 [&>svg]:shrink-0">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Редактировать задачу</DialogTitle>
                <DialogDescription>
                    Заполните форму, чтобы редактировать задачу.
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
                    <ProjectUsers :project-users="props.projectUsers" v-model="form.responsible_id" />
                </div>
                <Button type="submit" class="w-full">Создать</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>