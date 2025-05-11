<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import MainLayout from '@/Layouts/MainLayout.vue';

</script>

<template>

    <Head :title="$page.props.auth.user.name" />

    <MainLayout></MainLayout>
</template>