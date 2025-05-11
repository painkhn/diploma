<script setup lang="ts">
import { cn } from '@/lib/utils'
import { Button } from '@/Components/ui/button'
import { Calendar } from '@/Components/ui/calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'
import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
    parseDate,
} from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'
import { ref, watch } from 'vue'

const props = defineProps<{
    modelValue?: string
}>()

const emit = defineEmits(['update:modelValue'])

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
})

const value = ref<DateValue>()

// Инициализация значения, если передано
if (props.modelValue) {
    value.value = parseDate(props.modelValue)
}

// Отслеживание изменений и передача родителю
watch(value, (newValue) => {
    if (newValue) {
        emit('update:modelValue', newValue.toString())
    } else {
        emit('update:modelValue', '')
    }
})
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline" :class="cn(
                'w-full justify-start text-left font-normal',
                !value && 'text-muted-foreground',
            )">
                <CalendarIcon class="mr-2 h-4 w-4" />
                {{ value ? df.format(value.toDate(getLocalTimeZone())) : "Выберите дату" }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar v-model="value" initial-focus />
        </PopoverContent>
    </Popover>
</template>