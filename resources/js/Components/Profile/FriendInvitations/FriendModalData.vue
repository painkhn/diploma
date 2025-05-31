<script setup lang="ts">
import { Friend } from '@/types';
import { Link, useForm } from '@inertiajs/vue3';
import { Check, X } from 'lucide-vue-next';
import { onMounted } from 'vue';

const props = defineProps<{
    notification: Friend
}>()

const acceptForm = useForm({})

const acceptSubmit = () => {
    acceptForm.patch(route('friend.accept', { id: props.notification.id }))
}

// onMounted(() => {
//     console.log(props.notification.sender.id);
// })
</script>

<template>
    <div class="flex items-center w-full">
        <div class="w-2/3">
            <Link :href="route('profile.show', { id: notification.sender.id })"
                class="transition-all hover:opacity-80 hover:underline text-sm uppercase">
            {{ notification.sender.name }}
            </Link>
            <span class="text-sm font-semibold">
                пригласил вас в друзья
            </span>
        </div>
        <div class="w-1/3 flex justify-end gap-5">
            <form @submit.prevent="acceptSubmit" class="size-5">
                <button type="submit">
                    <Check
                        class="size-5 text-green-500 dark:text-green-400 transition-all hover:text-green-400 hover:dark:text-green-300" />
                </button>
            </form>
            <form class="size-5">
                <button>
                    <X
                        class="size-5 text-red-500 dark:text-red-400 transition-all hover:text-red-400 hover:dark:text-red-300" />
                </button>
            </form>
        </div>
    </div>
</template>