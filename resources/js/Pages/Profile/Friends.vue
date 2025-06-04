<script setup lang="ts">
import AddFriendModal from '@/Components/Profile/Friends/AddFriendModal.vue';
import Button from '@/Components/ui/button/Button.vue';
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Friend, Invitation, Project, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Image, Plus } from 'lucide-vue-next';

const props = defineProps<{
    users: User[];
    user: User;
    invitations: Invitation[] | null;
    friendInvitations: Friend[] | undefined;
    friends: Friend[] | null
}>()
</script>

<template>

    <Head :title="props.user.name" />

    <ProfileLayout :friendInvitations="props.friendInvitations" :user="props.user" :invitations="props.invitations">
        <!-- <Button class="!text-white dark:!text-black">
            <Plus />
            Добавить нового друга
        </Button> -->
        <AddFriendModal :users="props.users">
            <Plus class="size-4" />
            Добавить нового друга
        </AddFriendModal>
        <ul class="mt-5 grid grid-cols-3 gap-5">
            <li v-for="(friend, index) in props.friends" :key="index">
                <div
                    class="p-5 border border-black/20 dark:border-white/20 transition-all hover:border-black/40 hover:dark:border-white/40 rounded-md flex gap-2">
                    <div
                        class="w-14 h-14 overflow-hidden flex items-center justify-center rounded-full border-2 border-black/20 dark:border-white/20">
                        <Image v-if="friend.receiver?.avatar === null" class="w-8 h-8 stroke-1 opacity-80" />
                        <img :src="`/storage/` + friend.sender?.avatar" alt=""
                            v-if="friend.receiver_id === props.user.id">
                        <img :src="`/storage/` + friend.receiver?.avatar" alt=""
                            v-if="friend.sender_id === props.user.id">
                    </div>
                    <div class="font-semibold">
                        <Link :href="route('profile.show', { id: friend.receiver.id })"
                            v-if="friend.sender_id === props.user.id">
                        {{ friend.receiver.name }}
                        </Link>
                        <Link :href="route('profile.show', { id: friend.sender.id })"
                            v-if="friend.receiver_id === props.user.id">
                        {{ friend.sender.name }}
                        </Link>
                    </div>
                </div>
            </li>
        </ul>
    </ProfileLayout>
</template>