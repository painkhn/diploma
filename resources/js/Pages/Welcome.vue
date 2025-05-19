<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Header from '@/Components/Header/Index.vue'

import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>

    <Head title="Главная странциа" />

    <MainLayout>
        <div class="min-h-[calc(100vh-250px)] w-full flex items-center justify-center">
            <div class="space-y-4 text-center">
                <h1 class="font-black text-6xl">TechProject</h1>
                <p class="max-w-[400px]">
                    Создавайте проекты, собирайте команды, планируйте задачи. А мы всё это с радостью автоматизируем!
                </p>
            </div>
        </div>
    </MainLayout>
</template>
