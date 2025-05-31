<script setup lang="ts">
import AddUserModal from '@/Components/Project/AddUserModal.vue';
import ProjectUsersList from '@/Components/Project/ProjectUsersList.vue';
import UpdateProjectModal from '@/Components/Project/UpdateProjectModal.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Project, ProjectUser, Task, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { UserRoundPlus } from 'lucide-vue-next';
import { defineProps } from 'vue';
import CreateTaskModal from '@/Components/Project/Task/CreateTaskModal.vue'
import TaskList from '@/Components/Project/Task/TaskList.vue';
import Chart from '@/Components/Project/Chart.vue';

const props = defineProps<{
    project: Project
    users: User[]
    projectUsers: ProjectUser[] | undefined
}>()

// onMounted(() => {
//     console.log(props.project.tasks);
// })
</script>

<template>

    <Head :title="props.project.title" />

    <MainLayout>
        <div class="flex justify-between gap-8 max-[1270px]:gap-0 max-[840px]:flex-col">
            <div class="w-1/2 space-y-8 max-[840px]:w-full">
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
                    <div
                        class="opacity-80 font-semibold flex items-center gap-x-8 max-[1230px]:flex-col max-[1230px]:items-start max-[1230px]:gap-y-4">
                        <p>
                            {{ new Date(props.project.start_date).toLocaleDateString() }}
                            -
                            {{ new Date(props.project.end_date).toLocaleDateString() }}
                        </p>
                        <div class="gap-x-8 flex items-center">
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
                </div>
                <div class="space-y-4">

                    <TaskList v-if="(props.project.tasks as Task[])?.length > 0" :tasks="props.project.tasks"
                        :project="props.project" :project-users="props.projectUsers" />
                    <div v-else>
                        Нет ни одной доступной задачи
                    </div>
                </div>
            </div>
            <div
                class="flex w-1/2 max-[840px]:w-full max-[840px]:flex-row-reverse justify-between max-[1400px]:justify-end max-[1400px]:gap-y-8 max-[840px]:gap-y-0 max-[1400px]:flex-col-reverse max-[560px]:flex-col-reverse max-[560px]:gap-y-4">
                <div class="w-2/3 max-[1400px]:w-full max-[1400px]:items-start max-[840px]:w-1/2 max-[560px]:w-full"
                    v-if="$page.props.auth.user.id === props.project.user.id">
                    <Chart :tasks="props.project.tasks" :project-users="props.projectUsers" :project="props.project" />
                </div>
                <!-- <div v-else class="col-span-2"></div> -->
                <div class="w-1/3 max-[1400px]:max-w-[300px] max-[1400px]:w-full max-[840px]:w-1/2 max-[1400px]:mx-auto max-[560px]:w-full space-y-4"
                    :class="$page.props.auth.user.id !== props.project.user_id ? 'ml-auto' : ''">
                    <h2 class="text-2xl font-semibold text-center">
                        Пользователи проекта
                    </h2>
                    <AddUserModal :project="props.project" :users="props.users">
                        <UserRoundPlus />
                        Пригласить пользователя
                    </AddUserModal>
                    <ProjectUsersList :project-users="props.projectUsers" :project="props.project" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>