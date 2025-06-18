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
import Label from '../ui/label/Label.vue';
import Input from '../ui/input/Input.vue';
import Textarea from '../ui/textarea/Textarea.vue';
import DatePicker from './CreateModal/DatePicker.vue';
import Button from '../ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Loader from '../Loader/Loader.vue';
import { useToast } from '@/Components/ui/toast/use-toast'

const { toast } = useToast()

const form = useForm({
    title: '',
    description: '',
    start_date: '',
    end_date: '',
});

const errorMessage = ref('');

const isLoading = ref<boolean>(false)

const submit = () => {
    isLoading.value = true

    form.post(route('project.store'), {
        onSuccess: () => {
            form.reset();
            toast({
                title: 'Успешно!',
                description: 'Вы успешно создали проект',
            })
        },
        onError: (errors) => {
            errorMessage.value = Object.values(errors).join('\n');
            console.log(errorMessage);
        },
        onFinish: () => {
            isLoading.value = false
        }
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
                    <span v-if="form.errors.title" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.title }}
                    </span>
                </div>
                <div class="space-y-2">
                    <Label>Описание проекта</Label>
                    <Textarea v-model="form.description" type="text" />
                    <span v-if="form.errors.description" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.description }}
                    </span>
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
                <div class="flex flex-col">
                    <span v-if="form.errors.start_date" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.start_date }}
                    </span>
                    <span v-if="form.errors.end_date" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.end_date }}
                    </span>
                </div>
                <Button type="submit" variant="default" :disabled="isLoading"
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">
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