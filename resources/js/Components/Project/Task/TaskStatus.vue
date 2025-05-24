<script setup lang="ts">
import { Task } from '@/types';

const props = defineProps<{
    task: Task
}>()
</script>

<template>
    <div class="flex items-center gap-x-2 text-nowrap">
        <div v-if="task.status === 'pending'" :class="task.status === 'pending' ? 'bg-yellow-400' : ''"
            class="w-2 h-2 rounded-full"></div>
        <div v-if="task.status === 'consideration'" :class="task.status === 'consideration' ? 'bg-blue-400' : ''"
            class="w-2 h-2 rounded-full">
        </div>
        <div v-if="task.status === 'completed'" :class="task.status === 'completed' ? 'bg-green-400' : ''"
            class="w-2 h-2 rounded-full">
        </div>
        <div v-if="task.status === 'canceled'" :class="task.status === 'canceled' ? 'bg-red-400' : ''"
            class="w-2 h-2 rounded-full"></div>

        <span v-if="task.status === 'pending'">{{ task.status === 'pending' ? 'В процессе' : '' }}</span>
        <span v-if="task.status === 'consideration'">{{ task.status === 'consideration' ? 'На рассмотрении' : ''
            }}</span>
        <span v-if="task.status === 'completed'">{{ task.status === 'completed' ? 'Выполнено' : '' }}</span>
        <span v-if="task.status === 'canceled'">{{ task.status === 'canceled' ? 'Отменено' : '' }}</span>
    </div>
</template>