<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'
import { Ellipsis } from 'lucide-vue-next';
import MoreModal from './Actions/MoreModal.vue';
import { Task } from '@/types';

const props = defineProps<{
    task: Task
}>()
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger class="w-8 h-8 ml-auto flex items-center justify-center transition-all rounded-md hover:dark:bg-white/10">
            <Ellipsis />
        </DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuLabel>Действия</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <!-- <DropdownMenuItem> -->
            <MoreModal :task="props.task">Подробнее</MoreModal>
            <!-- </DropdownMenuItem> -->
            <DropdownMenuItem>Отправить отчёт</DropdownMenuItem>
            <DropdownMenuItem>Редактировать</DropdownMenuItem>
            <DropdownMenuItem>Список отчётов</DropdownMenuItem>
            <!-- <DropdownMenuItem>Subscription</DropdownMenuItem> -->
        </DropdownMenuContent>
    </DropdownMenu>
</template>