<script setup lang="ts">
import { ScrollArea } from '@/Components/ui/scroll-area'
import { Separator } from '@/Components/ui/separator'
import { Report } from '@/types';

const tags = Array.from({ length: 50 }).map(
    (_, i, a) => `v1.2.0-beta.${a.length - i}`,
)

const props = defineProps<{
    reports: Report[] | undefined
}>()
</script>

<template>
    <ScrollArea class="h-72 w-full rounded-md border">
        <div class="p-4">
            <h4 class="mb-4 text-sm font-medium leading-none">
                Отчёты
            </h4>

            <div v-for="(item, index) in props.reports" :key="index">
                <button class="text-sm w-full text-left line-clamp-1 p-2 rounded-md transition-all hover:dark:bg-white/10">
                    <!-- {{ tag }} -->
                    {{ item.content }}
                </button>
                <Separator class="my-2" />
            </div>
        </div>
    </ScrollArea>
</template>