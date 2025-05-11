<script setup lang="ts">
const data = [
    {
        title: 'Профиль',
        link: route("profile.show"),
    },
]
</script>

<template>
    <ul class="text-sm font-semibold">
        <li v-for="(item, index) in data" :key="index">
            <a :href="item.link" class="px-4 py-2 transition-all rounded-md hover:bg-white/10">
                {{ item.title }}
            </a>
        </li>
    </ul>
</template>