<script setup lang="ts">
import Button from '@/Components/ui/button/Button.vue'
import NavigationMenu from '@/Components/Header/NavigationMenu.vue';
import AuthModal from '@/Components/Header/AuthModal.vue';
import RegisterModal from './RegisterModal.vue';
import ThemeToggle from './ThemeToggle.vue';
</script>

<template>
    <header class="w-full p-5">
        <div class="grid grid-cols-3 items-center">
            <div class="justify-self-start">
                <a class="text-black dark:text-white text-2xl font-semibold transition-all hover:opacity-80"
                    href="/">TechProject</a>
            </div>
            <div class="justify-self-center items-center">
                <NavigationMenu v-if="$page.props.auth.user" />
            </div>
            <div class="justify-self-end flex items-center">
                <RegisterModal v-if="!$page.props.auth.user">
                    <Button variant="link">Регистрация</Button>
                </RegisterModal>
                <AuthModal v-if="!$page.props.auth.user">
                    <Button variant="outline" class="transition-all hover:bg-black/10 hover:dark:bg-white/10">Войти</Button>
                </AuthModal>
                <ThemeToggle class="ml-2" />
            </div>
        </div>
    </header>
</template>