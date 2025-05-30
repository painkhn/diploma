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
                    <span v-if="form.errors.name" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div class="space-y-2">
                    <Label>Электронная почта</Label>
                    <Input v-model="form.email" type="email" />
                    <span v-if="form.errors.email" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.email }}
                    </span>
                </div>
                <div class="space-y-2">
                    <Label>Пароль</Label>
                    <Input v-model="form.password" type="password" />
                    <span v-if="form.errors.password" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.password }}
                    </span>
                </div>
                <div class="space-y-2">
                    <Label>Повторите пароль</Label>
                    <Input v-model="form.password_confirmation" type="password" />
                    <span v-if="form.errors.password_confirmation" class="text-sm text-red-500 dark:text-red-400">
                        {{ form.errors.password_confirmation }}
                    </span>
                </div>
                <Button type="submit" variant="default"
                    class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">Регистрация</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>