<script setup lang="ts">
import { Moon, Sun } from 'lucide-vue-next';
import { Button } from '@/Components/ui/button';
import { ref, onMounted } from 'vue';

const theme = ref<'light' | 'dark'>('light');

// Проверяем сохранённую тему или системные настройки
onMounted(() => {
    const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | null;
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    theme.value = savedTheme || (systemPrefersDark ? 'dark' : 'light');
    applyTheme();
});

const toggleTheme = () => {
    theme.value = theme.value === 'dark' ? 'light' : 'dark';
    applyTheme();
    localStorage.setItem('theme', theme.value);
};

const applyTheme = () => {
    if (theme.value === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};
</script>

<template>
    <Button @click="toggleTheme" variant="ghost" size="icon" class="w-10 h-10 transition-all hover:dark:bg-white/10"
        aria-label="Toggle theme">
        <Sun v-if="theme === 'light'" class="h-[1.2rem] w-[1.2rem]" />
        <Moon v-else class="h-[1.2rem] w-[1.2rem]" />
    </Button>
</template>