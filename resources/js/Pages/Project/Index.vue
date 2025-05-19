<script setup lang="ts">
import AddUserModal from '@/Components/Project/AddUserModal.vue';
import ProjectUsersList from '@/Components/Project/ProjectUsersList.vue';
import UpdateProjectModal from '@/Components/Project/UpdateProjectModal.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Project, ProjectUser, Task, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { UserRoundPlus } from 'lucide-vue-next';
import { onMounted, defineProps } from 'vue';
import CreateTaskModal from '@/Components/Project/Task/CreateTaskModal.vue'
import TaskList from '@/Components/Project/Task/TaskList.vue';
import Chart from '@/Components/Project/Chart.vue';

const props = defineProps<{
    project: Project
    users: User[]
    projectUsers: ProjectUser[] | undefined
}>()



onMounted(() => {
    console.log(props.project.tasks); // Это покажет связи ProjectUser
})
</script>

<template>

    <Head :title="props.project.title" />

    <MainLayout>
        <div class="flex justify-between gap-8">
            <div class="w-1/2 space-y-8">
                <div class="w-full space-y-4">
                    <div class="flex items-center gap-x-4">
                        <h1 class="text-4xl font-black">
                            {{ props.project.title }}
                        </h1>
                        <span class="text-4xl">|</span>
                        <Link class="text-2xl opacity-80 transition-all hover:opacity-100 font-semibold mt-1"
                            :href="route('profile.show', { id: props.project.user_id })">({{ props.project.user.name }})
                        </Link>
                    </div>
                    <p class="text-2xl opacity-80">
                        {{ props.project.description }}
                    </p>
                    <div class="opacity-80 font-semibold flex items-center gap-x-8">
                        <p>
                            {{ new Date(props.project.start_date).toLocaleDateString() }}
                            -
                            {{ new Date(props.project.end_date).toLocaleDateString() }}
                        </p>
                        <div v-if="$page.props.auth.user.id === props.project.user.id">
                            <UpdateProjectModal :project="props.project">
                                Редактировать проект
                            </UpdateProjectModal>
                        </div>
                        <div v-if="$page.props.auth.user.id === props.project.user.id">
                            <CreateTaskModal :project="props.project" :project-users="props.projectUsers">
                                Добавить новую задачу
                            </CreateTaskModal>
                        </div>
                    </div>
                </div>
                <div class="">
                    <TaskList v-if="(props.project.tasks as Task[])?.length > 0" :tasks="props.project.tasks"
                        :project="props.project" :project-users="props.projectUsers" />
                    <div v-else>
                        Нет ни одной доступной задачи
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 w-1/2 justify-end gap-x-4">
                <div class="w-[400px] col-span-2 justify-self-center"
                    v-if="$page.props.auth.user.id === props.project.user.id">
                    <Chart :tasks="props.project.tasks" :project-users="props.projectUsers" />
                </div>
                <div v-else class="col-span-2"></div>
                <div class="max-w-[280px] col-span-1 w-full space-y-4 justify-self-end">
                    <h2 class="text-2xl font-semibold text-center">
                        Пользователи проекта
                    </h2>
                    <AddUserModal :project="props.project" :users="props.users">
                        <UserRoundPlus />
                        Пригласить пользователя
                    </AddUserModal>
                    <ProjectUsersList :project-users="props.projectUsers" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>