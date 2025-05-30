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
        <SelectTrigger class="w-[40%]">
            <SelectValue placeholder="Выберите срочность" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectLabel>Варианты срочности</SelectLabel>
                <SelectItem :value="null">
                    Без сортировки
                </SelectItem>
                <SelectItem value="fast">
                    Сначала срочные
                </SelectItem>
                <SelectItem value="lazy">
                    Сначала продолжительные
                </SelectItem>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>