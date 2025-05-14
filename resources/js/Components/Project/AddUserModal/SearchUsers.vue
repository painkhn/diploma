<script setup lang="ts">
import { cn } from '@/lib/utils'
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList } from '@/Components/ui/combobox'
import { Check, Search } from 'lucide-vue-next'
import { defineProps, ref } from 'vue'
import { User } from '@/types';

const props = defineProps<{
    users: any
}>()

const selectedUser = ref<User | null>(null)

const displayName = (user: User | null) => {
    return user?.name || ''
}
</script>

<template>
    <Combobox v-model="selectedUser" by="name">
        <ComboboxAnchor>
            <div class="relative w-full max-w-sm items-center">
                <ComboboxInput class="pl-9" :display-value="displayName" placeholder="Select user..." />
                <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                    <Search class="size-4 text-muted-foreground" />
                </span>
            </div>
        </ComboboxAnchor>

        <ComboboxList>
            <ComboboxEmpty>
                не найдено.
            </ComboboxEmpty>

            <ComboboxGroup>
                <ComboboxItem v-for="(user, index) in props.users" :key="index" :value="user">
                    {{ user?.name }}

                    <ComboboxItemIndicator>
                        <Check :class="cn('ml-auto h-4 w-4')" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>