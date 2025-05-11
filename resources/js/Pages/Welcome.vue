<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Header from '@/Components/Header/Index.vue'

import MainLayout from '@/Layouts/MainLayout.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>

    <Head title="Главная странциа" />

    <MainLayout></MainLayout>
</template>
