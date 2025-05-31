<script setup lang="ts">
import { Check, ChevronsUpDown } from 'lucide-vue-next'
import { ref, watch } from 'vue'
import { Button } from '@/Components/ui/button'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList
} from '@/Components/ui/command'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'
import { cn } from '@/lib/utils'
import { User } from '@/types'

const props = defineProps<{
    users: User[],
    modelValue: string | number | null // Добавляем поддержку v-model
}>()

const emit = defineEmits(['update:modelValue']) // Добавляем emit для v-model

const open = ref(false)
const selectedValue = ref(props.modelValue) // Локальное значение

// Синхронизируем изменения modelValue с локальным значением
watch(() => props.modelValue, (newVal) => {
    selectedValue.value = newVal
})

// Обработчик выбора пользователя
const handleSelect = (value: string | number) => {
    selectedValue.value = value
    emit('update:modelValue', value)
    open.value = false
}
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button variant="outline" role="combobox" :aria-expanded="open" class="w-full justify-between">
                {{selectedValue ? users.find((user) => user.id === selectedValue)?.name : 'Выберите пользователя...'}}
                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="!max-w-[500px] p-0">
            <Command>
                <CommandInput placeholder="Имя пользователя..." />
                <CommandEmpty>Пользователей не найдено.</CommandEmpty>
                <CommandList>
                    <CommandGroup>
                        <CommandItem v-for="(user, index) in props.users" :key="index" :value="user.id"
                            @select="() => handleSelect(user.id)">
                            <Check :class="cn(
                                'mr-2 h-4 w-4',
                                selectedValue === user.id ? 'opacity-100' : 'opacity-0',
                            )" />
                            {{ user.name }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>