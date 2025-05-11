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
import Button from '../ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Регистрация</DialogTitle>
                <DialogDescription>
                    Создайте аккаунт, чтобы пользоваться TechProject.
                </DialogDescription>
            </DialogHeader>
            <form class="space-y-4" @submit.prevent="submit">
                <div class="space-y-2">
                    <Label>Логин</Label>
                    <Input v-model="form.name" type="text" />
                </div>
                <div class="space-y-2">
                    <Label>Электронная почта</Label>
                    <Input v-model="form.email" type="email" />
                </div>
                <div class="space-y-2">
                    <Label>Пароль</Label>
                    <Input v-model="form.password" type="password" />
                </div>
                <div class="space-y-2">
                    <Label>Повторите пароль</Label>
                    <Input v-model="form.password_confirmation" type="password" />
                </div>
                <Button type="submit" variant="default"
                    class="w-full transition-all bg-white text-black hover:bg-gray-200">Войти</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>