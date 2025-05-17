<script setup lang="ts">
import { cn } from '@/lib/utils'
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList } from '@/Components/ui/combobox'
import { Check, Search } from 'lucide-vue-next'
import { ref, watch } from 'vue'

const props = defineProps<{
    projectUsers: any,
    modelValue: string | number | null
}>()

const emit = defineEmits(['update:modelValue'])

const selectedUser = ref()

// Watch for changes in selectedUser and emit the user_id
watch(selectedUser, (newValue) => {
    if (newValue) {
        emit('update:modelValue', newValue.user_id)
    } else {
        emit('update:modelValue', null)
    }
})
</script>

<template>
    <Combobox v-model="selectedUser" by="id">
        <ComboboxAnchor class="w-full">
            <div class="relative w-full items-center">
                <ComboboxInput class="pl-9" :display-value="(user) => user?.user?.name ?? ''"
                    placeholder="Выберите пользователя" />
                <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                    <Search class="size-4 text-muted-foreground" />
                </span>
            </div>
        </ComboboxAnchor>

        <ComboboxList>
            <ComboboxEmpty>
                Пользователь не найден.
            </ComboboxEmpty>

            <ComboboxGroup>
                <ComboboxItem v-for="(item, index) in props.projectUsers" :key="index" :value="item">
                    {{ item.user.name }}

                    <ComboboxItemIndicator>
                        <Check :class="cn('ml-auto h-4 w-4')" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>