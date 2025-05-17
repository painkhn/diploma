<script setup lang="ts">
import { cn } from '@/lib/utils'
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList } from '@/Components/ui/combobox'
import { Check, Search } from 'lucide-vue-next'

// const frameworks = [
//     { value: 'next.js', label: 'Next.js' },
//     { value: 'sveltekit', label: 'SvelteKit' },
//     { value: 'nuxt', label: 'Nuxt' },
//     { value: 'remix', label: 'Remix' },
//     { value: 'astro', label: 'Astro' },
// ]

import { defineProps, onMounted } from 'vue';

const props = defineProps<{
    projectUsers: any
}>()

onMounted(() => {
    console.log(props.projectUsers)
})
</script>

<template>
    <Combobox by="label">
        <ComboboxAnchor class="w-full">
            <div class="relative w-full items-center">
                <ComboboxInput class="pl-9" :display-value="(val) => val?.label ?? ''"
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
                <ComboboxItem v-for="(item, index) in props.projectUsers" :key="index" :value="item.id">
                    {{ item.user.name }}

                    <ComboboxItemIndicator>
                        <Check :class="cn('ml-auto h-4 w-4')" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>