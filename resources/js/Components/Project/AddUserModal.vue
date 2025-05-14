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
import { ref, computed, nextTick } from 'vue';
import { Input } from '@/Components/ui/input'
import { CircleMinus, Search, Trash2 } from 'lucide-vue-next'
import { Button } from '@/Components/ui/button'
import { Project, User } from '@/types';
import SearchUsers from './AddUserModal/SearchUsers.vue';

const props = defineProps<{
    users: User[]
    project: Project
}>()
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="w-full flex items-center gap-x-2 py-2 justify-center rounded-md transition-all hover:dark:bg-white/5">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Пригласить пользователя</DialogTitle>
                <DialogDescription>
                    Найдите пользователя по его имени пользователя, чтобы отправить ему приглашение.
                </DialogDescription>
            </DialogHeader>
            <div class="relative">
                <SearchUsers :project-id="props.project.id" :users="props.users" />
            </div>
            <DialogFooter>
                <!--  -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>