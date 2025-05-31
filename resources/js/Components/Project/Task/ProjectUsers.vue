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

watch(selectedUser, (newValue) => {
    emit('update:modelValue', newValue.user_id)
    // if (newValue) {
    // } else {
    //     emit('update:modelValue', null)
    // }
})
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
                <ComboboxItem v-for="(item, index) in projectUsers" :key="index" :value="item">
                    <div class="flex items-center gap-1">
                        <Crown v-if="item.user.id === $page.props.auth.user.id" class="size-4 text-yellow-500" />
                        {{ item.user.name }}
                        <span v-if="item.user.id === $page.props.auth.user.id">(Я)</span>
                    </div>

                    <ComboboxItemIndicator>
                        <Check :class="cn('ml-auto h-4 w-4')" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>