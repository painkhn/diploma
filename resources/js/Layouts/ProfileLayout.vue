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
import ModalData from '@/Components/Profile/ProjectInvitations/ModalData.vue';
import FriendModalData from '@/Components/Profile/FriendInvitations/FriendModalData.vue';

const props = defineProps<{
    user: User;
    invitations: Invitation[] | null;
    friendInvitations: Friend[] | undefined;
    // friends: any;
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
    console.log(props.friendInvitations);

    // console.log(props.invitations);
})
</script>

<template>

    <Head :title="props.user.name" />

    <MainLayout>
        <section class="flex justify-between">
            <div class="max-w-[300px] w-full p-5 text-center space-y-8 items-start">
                <UpdateAvatar v-if="$page.props.auth.user.id === props.user.id">
                    <div
                        class="w-full flex items-center justify-center h-[260px] rounded-full border-2 overflow-hidden border-black/80 dark:border-white">
                        <Image v-if="props.user?.avatar == null" class="w-20 h-20 stroke-1 opacity-80" />
                        <img v-else :src="`/storage/` + props.user?.avatar" alt="Аватарка" encType="multipart/form-data"
                            class="w-full min-h-[260px]">
                    </div>
                </UpdateAvatar>
                <div v-else
                    class="w-full flex items-center justify-center h-[260px] rounded-full border-2 overflow-hidden border-black/80 dark:border-white">
                    <Image v-if="props.user?.avatar == null" class="w-20 h-20 stroke-1 opacity-80" />
                    <img v-else :src="`/storage/` + props.user?.avatar" alt="Аватарка" encType="multipart/form-data"
                        class="w-full min-h-[260px]">
                </div>
                <ul class="space-y-2">
                    <li>
                        <Link :href="route('profile.show', { id: props.user.id })"
                            class="font-semibold text-lg uppercase hover:underline">{{ props.user?.name }}</Link>
                    </li>
                    <li>
                        <p>{{ props.user?.email }}</p>
                    </li>
                    <li v-if="props.user.id === $page.props.auth.user.id">
                        <CreateModal>
                            Создать проект
                        </CreateModal>
                    </li>
                    <li v-if="props.user.id === $page.props.auth.user.id">
                        <Link :href="route('friend.index', { id: props.user.id })"
                            class="transition-all hover:opacity-80">
                        Друзья
                        </Link>
                    </li>
                </ul>
                <form @submit.prevent="submit" v-if="props.user.id === $page.props.auth.user.id">
                    <Button type="submit" variant="outline" class="transition-all hover:dark:bg-white/10">Выход</Button>
                </form>
            </div>
            <div class="w-1/2 p-10">
                <div>
                    <p class="dark:text-white text-4xl mb-2.5">
                        {{ currentTime }}
                    </p>
                    <p class="dark:text-white text-lg opacity-90 mb-5">
                        {{ currentDateTime }}
                    </p>
                </div>
                <slot />
            </div>
            <div class="max-w-[300px] w-full p-5 space-y-8" v-if="$page.props.auth.user.id === props.user.id">
                <h2 class="text-2xl font-semibold text-center">
                    Уведомления
                </h2>
                <ul class="space-y-4" v-if="(props.invitations as Invitation[])?.length > 0">
                    <li v-for="(item, index) in props.invitations" :key="index">
                        <NotificationModal :notification="item" :title="'проект'">
                            <ModalData :notification="item" />
                        </NotificationModal>
                    </li>
                </ul>
                <ul class="space-y-4" v-if="(props.friendInvitations as Friend[])?.length > 0">
                    <li v-for="(item, index) in props.friendInvitations" :key="index">
                        <NotificationModal :notification="item" :title="'друзья'">
                            <FriendModalData :notification="item" />
                        </NotificationModal>
                    </li>
                </ul>
                <p v-else class="text-sm font-semibold text-center opacity-80">У вас нет новых уведомлений</p>
            </div>
            <div class="max-w-[300px] w-full" v-else></div>
        </section>

    </MainLayout>
</template>