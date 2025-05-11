<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import MainLayout from '@/Layouts/MainLayout.vue';
import { Image } from 'lucide-vue-next';
import Button from '@/Components/ui/button/Button.vue';
import { onMounted } from 'vue';
import UpdateAvatar from '@/Components/Profile/UpdateAvatar.vue';
import { User } from '@/types';

const props = defineProps<{
    user: User;
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

onMounted(() => {
    console.log(props.user);
})
</script>

<template>

    <Head :title="$page.props.auth.user.name" />

    <MainLayout>
        <section class="flex">
            <div class="max-w-[300px] w-full p-5 text-center space-y-8">
                <UpdateAvatar>
                    <div
                        class="w-full flex items-center justify-center h-[260px] rounded-full border-2 overflow-hidden dark:border-white">
                        <Image v-if="props.user?.avatar == null" class="w-20 h-20 stroke-1 opacity-80" />
                        <img v-else :src="`/storage/` + props.user?.avatar" alt="Аватарка" encType="multipart/form-data"
                            class="w-full min-h-[260px]">
                    </div>
                </UpdateAvatar>
                <ul class="space-y-2">
                    <li>
                        <h2 class="font-semibold text-lg uppercase">{{ props.user?.name }}</h2>
                    </li>
                    <p>
                    <p>{{ props.user?.email }}</p>
                    </p>
                </ul>
                <form @submit.prevent="submit">
                    <Button type="submit" variant="outline" class="transition-all hover:dark:bg-white/10">Выход</Button>
                </form>
            </div>
        </section>

    </MainLayout>
</template>