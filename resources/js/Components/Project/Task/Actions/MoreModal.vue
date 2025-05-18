<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import { Task } from '@/types';
import { Link } from '@inertiajs/vue3';
import { CalendarCheck, UserCheck } from 'lucide-vue-next';
import { defineProps, onMounted } from 'vue';

const props = defineProps<{
    task: Task
}>()
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="relative flex cursor-pointer w-full hover:dark:bg-white/10 select-none items-center rounded-sm gap-2 px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&>svg]:size-4 [&>svg]:shrink-0">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ props.task.title }}</DialogTitle>
                <DialogDescription>
                    {{ props.task.description }}.
                </DialogDescription>
            </DialogHeader>
            <ul class="space-y-2">
                <li>
                    <Link :href="route('profile.show', { id: props.task.responsible.id })" class="flex items-center gap-x-2 opacity-60 text-sm font-semibold transition-all hover:opacity-100">
                        <UserCheck />
                        {{ props.task.responsible.name }}
                    </Link>
                </li>
                <li>
                    <div class="flex items-center gap-x-2 opacity-60 text-sm font-semibold">
                        <CalendarCheck class="w-5 h-5" />
                        Дата окончания: {{ new Date(props.task.end_date).toLocaleDateString() }}
                    </div>
                </li>
            </ul>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>