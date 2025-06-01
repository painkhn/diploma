<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { ref, computed, nextTick } from 'vue';
import { Input } from '@/Components/ui/input'
import { CircleMinus, Search, Trash2 } from 'lucide-vue-next'
import { Button } from '@/Components/ui/button'
import { Friend, Project, User } from '@/types';
import SearchUsers from './AddUserModal/SearchUsers.vue';
import SearchSelect from './AddUserModal/SearchSelect.vue';
import Label from '../ui/label/Label.vue';
import RoleSelect from './AddUserModal/RoleSelect.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    users: User[]
    project: Project
    friends: Friend[] | undefined
}>()

const form = useForm({
    role: '',
    recipient_id: ''
})

const submit = () => {
    form.post(route('project.invitation.store', { id: props.project.id }), {
        onSuccess: () => {
            form.reset();
            console.log('Приглашение в проект успешно отправлено');
        },
        onError: (errors) => {
            console.log('Ошибка при отправке приглашения в проект, ', errors);
        }
    })
}
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="w-full flex items-center gap-x-2 py-2 justify-center rounded-md transition-all hover:dark:bg-white/5">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Пригласить пользователя</DialogTitle>
                <DialogDescription>
                    Найдите пользователя по его имени пользователя, чтобы отправить ему приглашение.
                </DialogDescription>
            </DialogHeader>
            <div class="relative">
                <form class="space-y-4" @submit.prevent="submit">
                    <div>
                        <Label>Имя пользователя</Label>
                        <SearchSelect v-model="form.recipient_id" :friends="props.friends" />
                    </div>
                    <div>
                        <Label>Роль</Label>
                        <RoleSelect v-model="form.role" />
                    </div>
                    <Button type="submit" class="text-white dark:text-black w-full transition-all hover:opacity-80">
                        Пригласить
                    </Button>
                </form>
            </div>
            <DialogFooter>
                <!--  -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>