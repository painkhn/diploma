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
import { onMounted } from 'vue';

const props = defineProps<{
    modelValue: string | null
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | null): void
}>()

const updateValue = (value: any) => {
    emit('update:modelValue', value)
}
</script>

<template>
    <Select :modelValue="modelValue" @update:modelValue="updateValue">
        <SelectTrigger class="w-[200px]">
            <SelectValue placeholder="Все статусы" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectItem :value="null">
                    Все статусы
                </SelectItem>
                <SelectItem value="pending">
                    В процессе
                </SelectItem>
                <SelectItem value="consideration">
                    На рассмотрении
                </SelectItem>
                <SelectItem value="completed">
                    Выполнено
                </SelectItem>
                <SelectItem value="canceled">
                    Отменено
                </SelectItem>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>