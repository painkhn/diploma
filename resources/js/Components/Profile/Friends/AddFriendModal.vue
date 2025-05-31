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
import Label from '@/Components/ui/label/Label.vue';
import { User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import UserSelect from './UserSelect.vue';
import Button from '@/Components/ui/button/Button.vue';

const props = defineProps<{
    users: User[]
}>()

const form = useForm({
    receiver_id: ''
})

const submit = () => {
    form.post(route('friend.store'), {
        onSuccess: () => {
            console.log('Приглашение успешно отправлено');
        },
        onError: (errors) => {
            console.log(errors);
        }
    })
}
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="px-4 py-2 text-sm font-semibold rounded-md flex items-center gap-2 transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Добавить пользователя в друзья</DialogTitle>
                <DialogDescription>
                    Найдите пользователя по имени и отправьте ему приглашение в друзья.
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <Label>Имя пользователя</Label>
                    <UserSelect v-model="form.receiver_id" :users="props.users" />
                </div>
                <Button type="submit"
                    class="w-full py-2 text-sm font-semibold rounded-md flex items-center gap-2 transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">
                    Отправить запрос
                </Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>