<script setup lang="ts">
import { cn } from '@/lib/utils'
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList } from '@/Components/ui/combobox'
import { Check, Search, Crown } from 'lucide-vue-next'
import { ref, watch, computed } from 'vue'

const props = defineProps<{
    projectUsers: any,
    modelValue: string | number | null,
    authUser: any // Добавляем пропс для аутентифицированного пользователя
}>()

const emit = defineEmits(['update:modelValue'])

const selectedUser = ref()

// Создаем computed свойство, объединяющее аутентифицированного пользователя и пользователей проекта
const allUsers = computed(() => {
    return [
        {
            user_id: props.authUser.id,
            user: {
                ...props.authUser,
                name: `${props.authUser.name} (Я)`, // Добавляем пометку
                is_owner: true // Флаг владельца
            }
        },
        ...props.projectUsers
    ]
})

// Watch for changes in selectedUser and emit the user_id
watch(selectedUser, (newValue) => {
    if (newValue) {
        emit('update:modelValue', newValue.user_id)
    } else {
        emit('update:modelValue', null)
    }
})

// Инициализируем выбранного пользователя, если modelValue пришел снаружи
watch(() => props.modelValue, (newValue) => {
    if (newValue) {
        selectedUser.value = allUsers.value.find(user => user.user_id === newValue)
    } else {
        selectedUser.value = null
    }
}, { immediate: true })
</script>

<template>
    <Combobox v-model="selectedUser" by="user_id">
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
                <ComboboxItem v-for="(item, index) in allUsers" :key="index" :value="item">
                    <div class="flex items-center gap-2">
                        <Crown v-if="item.user.is_owner" class="size-4 text-yellow-500" />
                        {{ item.user.name }}
                    </div>

                    <ComboboxItemIndicator>
                        <Check :class="cn('ml-auto h-4 w-4')" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>