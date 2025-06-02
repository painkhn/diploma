<script setup lang="ts">
import { Project, ProjectUser } from '@/types';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { Image, Trash2 } from 'lucide-vue-next';
import { onMounted } from 'vue';
import ActionsDropdown from './ProjectUsersList/ActionsDropdown.vue';

const props = defineProps<{
    projectUsers: ProjectUser[] | undefined
    project: Project
    currentProjectUser: ProjectUser
}>()

onMounted(() => {
    console.log(props.projectUsers);
})
</script>

<template>
    <ul class="space-y-4">
        <li v-for="(item, index) in props.projectUsers" :key="index">
            <div class="grid grid-cols-2 items-center px-5">
                <Link :href="route('profile.show', { id: item?.user.id })"
                    class="flex items-center gap-x-4 justify-self-start transition-all hover:opacity-80">
                <div
                    class="w-10 flex items-center justify-center h-10 rounded-full border-2 overflow-hidden dark:border-white/10">
                    <Image v-if="item.user?.avatar == null" class="w-5 h-5 stroke-1 opacity-80" />
                    <img v-else :src="`/storage/` + item.user?.avatar" alt="Аватарка" encType="multipart/form-data"
                        class="w-full min-h-5">
                </div>
                <span class="font-semibold">
                    {{ item?.user.name }}
                </span>
                </Link>
                <div class="justify-self-end">
                    <!-- <button @click="deleteUser(item.user.id)"
                        v-if="props.project.id === $page.props.auth.user.id && props.project.user_id !== item.user_id">
                        <Trash2 class="text-red-400 transition-all hover:text-red-300" />
                    </button> -->
                    <ActionsDropdown v-if="currentProjectUser.role === 'admin'" :project="props.project"
                        :current-project-user="props.currentProjectUser" :project-user="item" />
                </div>
            </div>
        </li>
    </ul>
</template>