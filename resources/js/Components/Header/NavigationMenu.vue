<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <ul class="text-sm font-semibold flex items-center">
        <li>
            <Link class="px-4 py-2 transition-all rounded-md hover:bg-black/10 hover:dark:bg-white/10"
                :href="route('profile.show', { id: $page.props.auth.user.id })">
            Профиль
            </Link>
        </li>
        <li>
            <Link class="px-4 py-2 transition-all rounded-md hover:bg-black/10 hover:dark:bg-white/10"
                :href="route('friend.index', { id: $page.props.auth.user.id })">
            Друзья
            </Link>
        </li>
    </ul>
</template>