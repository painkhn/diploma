<script setup lang="ts">
import Button from '@/Components/ui/button/Button.vue';
import Input from '@/Components/ui/input/Input.vue';
import Label from '@/Components/ui/label/Label.vue';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'
import Textarea from '@/Components/ui/textarea/Textarea.vue';
import { Task } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    task: Task
}>()

const form = useForm({
    message: '',
    file: null as File | null
});

const fileInput = ref<HTMLInputElement | null>(null);

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.file = target.files[0];
    }
};


const submit = () => {
    // Создаем FormData для загрузки файла
    const formData = new FormData();
    formData.append('message', form.message);
    if (form.file) {
        formData.append('file', form.file);
    }

    // Используем transform для преобразования данных перед отправкой
    form.transform((data) => {
        const formData = new FormData();
        formData.append('message', data.message);
        if (data.file) {
            formData.append('file', data.file);
        }
        return formData;
    }).post(route('report.reject', { id: props.task.id }), {
        onSuccess: () => {
            form.reset();
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
        onError: (errors) => {
            console.log('Ошибка при отправке отчёта', errors);
        },
        forceFormData: true // Указываем, что отправляем FormData
    });
};
</script>

<template>
    <Popover>
        <PopoverTrigger>
            <slot />
        </PopoverTrigger>
        <PopoverContent class="space-y-4">
            <h3 class="font-semibold">
                Форма обратной
            </h3>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-2">
                    <Label>Сообщение</Label>
                    <Textarea v-model="form.message" placeholder="Введите сообщение для вашего отчёта" />
                </div>
                <div class="space-y-2">
                    <Label>Файлы отчёта (если файлов несколько, отправляйте ZIP-архив)</Label>
                    <Input ref="fileInput" type="file" @change="handleFileChange"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png,.zip" />
                </div>
                <Button type="submit" variant="default"
                    class="w-full transition-all bg-white text-black hover:bg-gray-200">Отправить отчёт</Button>
            </form>
        </PopoverContent>
    </Popover>
</template>