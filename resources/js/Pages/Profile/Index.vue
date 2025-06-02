<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import MainLayout from '@/Layouts/MainLayout.vue';
import { Bell, Image } from 'lucide-vue-next';
import Button from '@/Components/ui/button/Button.vue';
import { onMounted, ref } from 'vue';
import UpdateAvatar from '@/Components/Profile/UpdateAvatar.vue';
import { Friend, Invitation, Project, User } from '@/types';
import CreateModal from '@/Components/Project/CreateModal.vue';
import NotificationModal from '@/Components/Profile/NotificationModal.vue';
import ProfileLayout from '@/Layouts/ProfileLayout.vue';

const props = defineProps<{
    user: User;
    projects: Project[] | null;
    invitations: Invitation[] | null;
    friendInvitations: Friend[] | undefined;
}>()

const form = useForm(
    {
        //
    }
)

const submit = () => {
    form.post(route('logout'), {
        onFinish: () => {
            // 
        },
    })
}

const currentDateTime = ref<string>('');
const currentTime = ref<string>('');

const updateDateTime = () => {
    const now = new Date();
    currentDateTime.value = now.toLocaleDateString();
}

const updateTime = () => {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0'); // Часы (с лидирующим нулем)
    const minutes = String(now.getMinutes()).padStart(2, '0'); // Минуты (с лидирующим нулем)
    const seconds = String(now.getSeconds()).padStart(2, '0'); // Секунды (с лидирующим нулем)
    currentTime.value = `${hours} : ${minutes} : ${seconds}`; // Форматируем время
};

let intervalId: number | undefined;

onMounted(() => {
    // console.log(props.user);
    updateDateTime();
    updateTime();
    intervalId = setInterval(updateTime, 1000);
    // console.log(props.invitations);
})
</script>

<template>

    <Head :title="props.user.name" />

    <ProfileLayout :friendInvitations="props.friendInvitations" :user="props.user" :invitations="props.invitations">
        <ul class="space-y-4" v-if="(props.projects as Project[])?.length > 0">
            <li v-for="(item, index) in props.projects" :key="index">
                <Link :href="route('project.index', { id: item.id })">
                <div
                    class="w-full py-2 border-l border-black/80 dark:border-white px-8 transition-all hover:border-l-4 hover:dark:bg-white/5">
                    <div class="flex items-center gap-x-2">
                        <h2 class="text-2xl font-semibold">{{ item.title }}</h2>
                        <span v-if="item.user_id === props.user.id"
                            class="opacity-80 mt-1 font-semibold">(Администратор)</span>
                    </div>
                    <p class="line-clamp-1 opacity-80">
                        {{ item.description }}
                    </p>
                </div>
                </Link>
            </li>
        </ul>
        <p class="text-sm font-semibold opacity-80" v-else>
            У вас нет доступных задач
        </p>
    </ProfileLayout>
</template>