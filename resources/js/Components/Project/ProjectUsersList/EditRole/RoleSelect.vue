<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select'
import { ProjectUser } from '@/types';

const props = defineProps<{
    projectUser: ProjectUser
}>()

const emit = defineEmits(['update:modelValue'])

const updateValue = (value: any) => {
    emit('update:modelValue', value)
}
</script>

<template>
    <Select :modelValue="projectUser.role" @update:modelValue="updateValue">
        <SelectTrigger>
            <SelectValue placeholder="Выберите роль" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectLabel>Роли</SelectLabel>
                <SelectItem value="moderator" v-if="projectUser.role !== 'moderator'">
                    Модератор
                </SelectItem>
                <SelectItem value="inspector" v-if="projectUser.role !== 'inspector'">
                    Проверяющий
                </SelectItem>
                <SelectItem value="user" v-if="projectUser.role !== 'user'">
                    Участник
                </SelectItem>
                <SelectItem value="admin" v-if="projectUser.role !== 'admin'">
                    Администратор
                </SelectItem>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>