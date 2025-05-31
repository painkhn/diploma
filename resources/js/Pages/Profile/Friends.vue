<script setup lang="ts">
import AddFriendModal from '@/Components/Profile/Friends/AddFriendModal.vue';
import Button from '@/Components/ui/button/Button.vue';
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Friend, Invitation, Project, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

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
        <ul>
            <li v-for="(friend, index) in props.friends" :key="index">
                <Link :href="route('profile.show', { id: friend.sender.id })">
                {{ friend.sender.name }}
                </Link>
            </li>
        </ul>
    </ProfileLayout>
</template>