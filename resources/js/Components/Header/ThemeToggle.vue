<script setup lang="ts">
import { Moon, Sun } from 'lucide-vue-next';
import { Button } from '@/Components/ui/button';
import { ref, onMounted } from 'vue';

const theme = ref<'light' | 'dark'>('light');

onMounted(() => {
    // Проверяем localStorage и системные настройки
    const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | null;
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    theme.value = savedTheme || (systemPrefersDark ? 'dark' : 'light');
    applyThemeToDocument();
});

const toggleTheme = () => {
    theme.value = theme.value === 'dark' ? 'light' : 'dark';
    applyThemeToDocument();
    localStorage.setItem('theme', theme.value);
};

// Функция для применения темы ко всему документу
const applyThemeToDocument = () => {
    const body = document.body;
    if (theme.value === 'dark') {
        body.classList.add('dark');
    } else {
        body.classList.remove('dark');
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