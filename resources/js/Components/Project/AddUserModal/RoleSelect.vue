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

const roles = [
    {
        value: 'user', label: 'Участник'
    },
    {
        value: 'moderator', label: 'Модератор'
    },
    {
        value: 'inspector', label: 'Проверяющий'
    },
]

const props = defineProps({
    modelValue: String
})

const emit = defineEmits(['update:modelValue'])

const open = ref(false)
const value = ref(props.modelValue)

watch(value, (newVal) => {
    emit('update:modelValue', newVal)
})
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button variant="outline" role="combobox" :aria-expanded="open" class="w-full justify-between">
                {{value ? roles.find((role) => role.value === value)?.label : 'Выберите роль...'}}

                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-[200px] p-0">
            <Command v-model="value">
                <CommandInput placeholder="Название роли..." />
                <CommandEmpty>Роль не найдена.</CommandEmpty>
                <CommandList>
                    <CommandGroup>
                        <CommandItem v-for="(role, index) in roles" :key="index" :value="role.value"
                            @select="open = false">
                            <Check :class="cn(
                                'mr-2 h-4 w-4',
                                value === role.value ? 'opacity-100' : 'opacity-0',
                            )" />
                            {{ role.label }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>