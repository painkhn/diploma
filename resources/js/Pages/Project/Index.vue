<script setup lang="ts">
import AddUserModal from '@/Components/Project/AddUserModal.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Project, ProjectUser, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { UserRoundPlus } from 'lucide-vue-next';
import { DefineProps, onMounted } from 'vue';

const props = defineProps<{
    project: Project
    users: User[]
    projectUsers: any
}>()

onMounted(() => {
    console.log(props.projectUsers); // Это покажет связи ProjectUser
})
</script>

<template>

    <Head :title="props.project.title" />

    <MainLayout>
        <div class="flex justify-between">
            <div class="w-1/2">
                <div class="w-full space-y-4">
                    <h1 class="text-4xl font-black">
                        {{ props.project.title }}
                    </h1>
                    <p class="text-2xl opacity-80">
                        {{ props.project.description }}
                    </p>
                    <div class="opacity-80 font-semibold">
                        <p>
                            {{ props.project.start_date }}
                            -
                            {{ props.project.end_date }}
                        </p>
                    </div>
                </div>
                <div class="">

                </div>
            </div>
            <div class="max-w-[280px] w-full space-y-4">
                <h2 class="text-2xl font-semibold text-center">
                    Пользователи проекта
                </h2>
                <AddUserModal :project="props.project" :users="props.users">
                    <UserRoundPlus />
                    Пригласить пользователя
                </AddUserModal>
                <ul>
                    <li v-for="(item, index) in props.projectUsers" :key="index">
                        <Link :href="route('profile.show', { id: item?.user.id })" class="flex items-center gap-x-4">
                        <div
                            class="w-full max-w-10 flex items-center justify-center h-10 rounded-full border-2 overflow-hidden dark:border-white/10">
                            <Image v-if="item.user?.avatar == null" class="w-5 h-5 stroke-1 opacity-80" />
                            <img v-else :src="`/storage/` + item.user?.avatar" alt="Аватарка"
                                encType="multipart/form-data" class="w-full min-h-5">
                        </div>
                        <span class="font-semibold">
                            {{ item?.user.name }}
                        </span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </MainLayout>
</template>