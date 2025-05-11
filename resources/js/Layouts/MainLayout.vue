<script setup lang="ts">
import Header from '@/Components/Header/Index.vue'
</script>

<template>
    <Header />

    <main class="p-5">
        <slot />
    </main>
</template>