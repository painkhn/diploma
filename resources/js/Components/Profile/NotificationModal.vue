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
import { Friend, Invitation } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { Bell, Check, X } from 'lucide-vue-next';
import { defineProps, ref } from 'vue';

const props = defineProps<{
    notification: Invitation | Friend;
    title: string
}>()




</script>

<template>
    <Dialog>
        <DialogTrigger class="w-full">
            <div class="dark:bg-white/5 transition-all hover:dark:bg-white/10 rounded-md p-4 flex items-center gap-x-4">
                <Bell />
                <h3 class="font-semibold line-clamp-1">
                    Приглашение в {{ title }}
                </h3>
            </div>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Вы приглашены в {{ title }}</DialogTitle>
                <DialogDescription>
                    Ниже предоставлена информация о приглашении и возможные действия.
                </DialogDescription>
            </DialogHeader>
            <div class="px-4 py-2 flex items-center rounded-md border dark:border-white/5 justify-between">
                <slot />
            </div>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>