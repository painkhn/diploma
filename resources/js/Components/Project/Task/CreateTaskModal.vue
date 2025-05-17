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

import Input from '@/Components/ui/input/Input.vue';
import Label from '@/Components/ui/label/Label.vue';
import Button from '@/Components/ui/button/Button.vue';
import Textarea from '@/Components/ui/textarea/Textarea.vue';
import DatePicker from '@/Components/Project/CreateModal/DatePicker.vue';
import ProjectUsers from '@/Components/Project/Task/ProjectUsers.vue'
import { ref } from 'vue'

import { Project, User } from '@/types';
import { defineProps } from 'vue';


const form = ref([
    'title',
    'description',
    'end_date',
    'responsible_id'
    // 'description'
])

const props = defineProps<{
    project: Project,
    projectUsers: any
}>()
</script>

<template>
    <Dialog>
        <DialogTrigger class="transition-all hover:opacity-80">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Создать задачу</DialogTitle>
                <DialogDescription>
                    Заполните форму, чтобы создать новую задачу.
                </DialogDescription>
            </DialogHeader>
            <form class="space-y-4">
                <div class="space-y-2">
                    <Label>Название задачи</Label>
                    <Input type="text" v-model="form.title" />
                </div>
                <div class="space-y-2">
                    <Label>Описание задачи</Label>
                    <Input type="text" v-model="form.description" />
                </div>
                <div class="space-y-2">
                    <Label>Дата окончания</Label>
                    <DatePicker type="text" v-model="form.end_date" />
                </div>
                <div class="space-y-2">
                    <Label>Ответственный пользователь</Label>
                    <ProjectUsers :project-users="props.projectUsers" />
                </div>
            </form>
            <DialogFooter>
                Save changes
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>