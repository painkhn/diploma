<script setup lang="ts">
import { Search } from 'lucide-vue-next'
import { Input } from '@/Components/ui/input'

const props = defineProps<{
    modelValue: string
}>()

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="relative w-full items-center">
        <Input id="search" type="text" placeholder="Поиск..." class="pl-10" :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)" />
        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
            <Search class="size-6 text-muted-foreground" />
        </span>
    </div>
</template>