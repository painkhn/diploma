<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue'
import NavigationMenu from '@/Components/Header/NavigationMenu.vue';
import AuthModal from '@/Components/Header/AuthModal.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <Head title="Welcome" />

    <header class="w-full p-5">
        <div class="grid grid-cols-3">
            <div class="justify-self-start">
                <span class="dark:text-white text-2xl font-semibold pointer-events-none">TechProject</span>
            </div>
            <div class="justify-self-center">
                <NavigationMenu v-if="$page.props.auth.user" />
            </div>
            <div class="justify-self-end">
                <AuthModal v-if="!$page.props.auth.user">
                    <Button variant="outline">Войти</Button>
                </AuthModal>
            </div>
        </div>
    </header>

    <main>

    </main>
</template>
