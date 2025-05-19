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
import Label from '../ui/label/Label.vue';
import Input from '../ui/input/Input.vue';
import Textarea from '../ui/textarea/Textarea.vue';
import DatePicker from './CreateModal/DatePicker.vue';
import Button from '../ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    title: '',
    description: '',
    start_date: '',
    end_date: '',
});

const errorMessage = ref('');

const submit = () => {
    form.post(route('project.store'), {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            errorMessage.value = Object.values(errors).join('\n');
            console.log(errorMessage);
        },
    });
}
</script>

<template>
    <Dialog>
        <DialogTrigger class="hover:underline font-semibold">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Создать прокт</DialogTitle>
                <DialogDescription>
                    Заполните форму, чтобы создать проект.
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-2">
                    <Label>Название проекта</Label>
                    <Input v-model="form.title" type="text" />
                </div>
                <div class="space-y-2">
                    <Label>Описание проекта</Label>
                    <Textarea v-model="form.description" type="text" />
                </div>
                <div class="gap-x-4 flex items-center">
                    <div class="space-y-2">
                        <Label>Дата начала проекта проекта</Label>
                        <DatePicker v-model="form.start_date" type="text" />
                    </div>
                    <div class="space-y-2">
                        <Label>Дата окончания проекта проекта</Label>
                        <DatePicker v-model="form.end_date" type="text" />
                    </div>
                </div>
                <Button type="submit" variant="default"
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">Создать</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>