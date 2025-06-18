<script setup lang="ts">
import Header from '@/Components/Header/Index.vue'
import Toaster from '@/Components/ui/toast/Toaster.vue'
</script>

<template>
    <Header />
    <Toaster />

    <main class="p-5">
        <slot />
    </main>
</template>