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
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};

const githubAuthUrl = route('github.login');
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Логин</DialogTitle>
                <DialogDescription>
                    Авторизируйтесь, чтобы пользоваться TechProject.
                </DialogDescription>
            </DialogHeader>
            <form class="space-y-4" @submit.prevent="submit">
                <div class="space-y-2">
                    <Label>Электронная почта</Label>
                    <Input v-model="form.email" type="email" />
                </div>
                <div class="space-y-2">
                    <Label>Пароль</Label>
                    <Input v-model="form.password" type="password" />
                </div>
                <Button type="submit" variant="default"
                    class="w-full transition-all bg-white text-black hover:bg-gray-200">Войти</Button>
            </form>
            <div class="w-full relative py-4">
                <div class="w-full h-[2px] z-10 bg-white absolute top-1/2 -translate-y-1/2"></div>
                <p class="bg-black absolute z-20 top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 px-2">ИЛИ</p>
            </div>
            <div class="grid">
                <a :href="githubAuthUrl" class="justify-self-center">
                    <button type="button"
                        class="flex items-center justify-center gap-2 transition-all hover:gap-1 text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                        </svg>
                        Войти через GitHub
                    </button>
                </a>
            </div>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>