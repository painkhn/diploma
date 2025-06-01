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
import { Friend } from '@/types'

const props = defineProps<{
    friends: Friend[] | undefined
    modelValue: string | undefined
}>()

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
                {{value ? props.friends?.find((friend) => friend.receiver.id === value)?.receiver.name : 'Выберите пользователя...'}}

                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="max-w-[400px] p-0">
            <Command v-model="value">
                <CommandInput placeholder="Имя пользователя..." />
                <CommandEmpty>Пользователи не найдены.</CommandEmpty>
                <CommandList>
                    <CommandGroup>
                        <CommandItem v-for="(friend, index) in props.friends" :key="index" :value="friend.receiver.id"
                            @select="open = false">
                            <Check :class="cn(
                                'mr-2 h-4 w-4',
                                value === friend.receiver.id ? 'opacity-100' : 'opacity-0',
                            )" />
                            {{ friend.receiver.name }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>