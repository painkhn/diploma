<script setup lang="ts">
import { Invitation } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { X, Check } from 'lucide-vue-next'

const isLoading = ref(false);
const error = ref<string | null>(null);

const props = defineProps<{
    notification: Invitation;
}>()

const acceptInvitation = async () => {
    isLoading.value = true;
    error.value = null;

    try {
        await router.post(`/invitations/${props.notification.id}/accept`, {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Можно добавить дополнительную логику после успешного принятия
            },
            onError: (errors) => {
                error.value = errors.message || 'Ошибка при принятии приглашения';
            }
        });
    } catch (e) {
        error.value = 'Произошла ошибка';
    } finally {
        isLoading.value = false;
    }
}

const rejectInvitation = async () => {
    isLoading.value = true;
    error.value = null;

    try {
        await router.post(`/invitations/${props.notification.id}/reject`, {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Можно добавить дополнительную логику после успешного отклонения
            },
            onError: (errors) => {
                error.value = errors.message || 'Ошибка при отклонении приглашения';
            }
        });
    } catch (e) {
        error.value = 'Произошла ошибка';
    } finally {
        isLoading.value = false;
    }
}
</script>

<template>
    <div>
        <Link :href="route('project.index', { id: notification.project_id })"
            class="text-sm font-semibold transition-all hover:opacity-80">
        Перейти на страницу проекта
        <!-- {{ notification.role }} -->
        </Link>
        <p class="font-semibold text-sm opacity-80 flex items-center gap-1">
            Роль:
            <span v-if="notification.role === 'moderator'">
                Модератор
            </span>
            <span v-if="notification.role === 'inspector'">
                Проверяющий
            </span>
            <span v-if="notification.role === 'user'">
                Участник
            </span>
        </p>
    </div>
    <div class="flex items-center gap-4">
        <button @click="acceptInvitation" :disabled="isLoading">
            <Check class="text-green-400 transition-all hover:text-green-300" />
            <span v-if="isLoading" class="sr-only">Загрузка...</span>
        </button>
        <button @click="rejectInvitation" :disabled="isLoading" class="text-red-400 transition-all hover:text-red-300">
            <X />
            <span v-if="isLoading" class="sr-only">Загрузка...</span>
        </button>
    </div>
</template>