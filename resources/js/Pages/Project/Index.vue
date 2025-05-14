<script setup lang="ts">
import AddUserModal from '@/Components/Project/AddUserModal.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Project, User } from '@/types';
import { Head } from '@inertiajs/vue3';
import { UserRoundPlus } from 'lucide-vue-next';
import { DefineProps, onMounted } from 'vue';

const props = defineProps<{
    project: Project
    users: User[]
}>()

// onMounted(() => {
//     console.log(props.users);
// })
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
            <div class="max-w-[400px] w-full space-y-4">
                <h2 class="text-2xl font-semibold text-center">
                    Пользователи проекта
                </h2>
                <AddUserModal :project="props.project" :users="props.users">
                    <UserRoundPlus />
                    Пригласить пользователя
                </AddUserModal>
            </div>
        </div>
    </MainLayout>
</template>