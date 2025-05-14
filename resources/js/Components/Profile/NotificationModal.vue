<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import { Invitation } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { Check, X } from 'lucide-vue-next';
import { defineProps, ref } from 'vue';

const props = defineProps<{
    notification: Invitation;
}>()

const isLoading = ref(false);
const error = ref<string | null>(null);

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
    <Dialog>
        <DialogTrigger class="w-full">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Вы приглашены в проект</DialogTitle>
                <DialogDescription>
                    Ниже предоставлена информация о приглашении и возможные действия.
                </DialogDescription>
            </DialogHeader>
            <div class="px-4 py-2 flex items-center rounded-md border dark:border-white/5 justify-between">
                <Link :href="route('project.index', { id: notification.project_id })"
                    class="text-sm font-semibold transition-all hover:opacity-80">
                Перейти на страницу проекта
                </Link>
                <div class="flex items-center gap-4">
                    <button @click="acceptInvitation" :disabled="isLoading">
                        <Check class="text-green-400 transition-all hover:text-green-300" />
                        <span v-if="isLoading" class="sr-only">Загрузка...</span>
                    </button>
                    <button @click="rejectInvitation" :disabled="isLoading"
                        class="text-red-400 transition-all hover:text-red-300">
                        <X />
                        <span v-if="isLoading" class="sr-only">Загрузка...</span>
                    </button>
                </div>
            </div>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>