<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue'

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
    
    <header class="w-full border dark:border-white p-10">

    </header>

    <main>
        
    </main>
</template>
