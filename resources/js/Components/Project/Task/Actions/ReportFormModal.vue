<script setup lang="ts">
import Button from '@/Components/ui/button/Button.vue';
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
import Textarea from '@/Components/ui/textarea/Textarea.vue';
import { Task } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    task: Task
}>()

const form = useForm({
    content: ''
})

const submit = () => {
    form.post(route('report.store', { id: props.task.id }), {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.log('ошибка при отправке отчёта');
        },
    })
}
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="relative flex cursor-pointer w-full hover:dark:bg-white/10 select-none items-center rounded-sm gap-2 px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&>svg]:size-4 [&>svg]:shrink-0">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Отправить отчёт</DialogTitle>
                <DialogDescription>
                    Заполните форму ниже, чтобы отправить отчёт. Ваш руководитель автоматически получит ваш отчёт и
                    вынесет решение.
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-2">
                    <Label>Контент</Label>
                    <Textarea v-model="form.content" placeholder="Введите текст вашего отчёта" />
                </div>
                <Button type="submit" variant="default"
                    class="w-full transition-all bg-white text-black hover:bg-gray-200">Отправить отчёт</Button>
            </form>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>