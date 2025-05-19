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

import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import axios from 'axios';
import { ref } from 'vue';
import Button from '../ui/button/Button.vue';

const avatarFile = ref(null);

const handleFileChange = (event: any) => {
    avatarFile.value = event.target.files[0];
};

const submit = async () => {
    if (!avatarFile.value) {
        alert('Пожалуйста, выберите файл для загрузки.');
        return;
    }

    const formData = new FormData();
    formData.append('avatar_change', avatarFile.value);

    try {
        await axios.post(route('profile.avatar.update'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        // Обработка успешного изменения аватарки
        avatarFile.value = null; // Сбросить выбранный файл
        location.reload()
        // console.log('аватарка успешно изменена')
        // alert('Новая аватарка успешно установлена!')
    } catch (error) {
        // Обработка ошибок валидации
        console.error('Произошла ошибка при загрузке аватарки:', error);
        // alert('Произошла ошибка при загрузке аватарки: ' + error.response.data.errors.avatar_change.join(', '));
    }
}
</script>

<template>
    <Dialog>
        <DialogTrigger class="w-full">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Изменить аватар</DialogTitle>
                <DialogDescription>
                    Выберите изображение, которое хотите видеть в качестве своего аватара (jpg, png, jpeg, webp).
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="grid w-full max-w-sm items-center gap-1.5 space-y-2">
                    <Label for="picture">Выберите изображение</Label>
                    <Input @change="handleFileChange" id="picture" type="file" class="cursor-pointer text-white" />
                </div>
                <Button type="submit"
                    class="transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">Сохранить</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>