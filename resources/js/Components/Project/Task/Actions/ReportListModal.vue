<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import ScrollArea from './ReportList/ScrollArea.vue';
import { onMounted } from 'vue';
import { Report, Task } from '@/types';

const props = defineProps<{
    reports: Report[] | undefined
    task: Task
}>()

// onMounted(() => {
//     console.log(props.reports);
// })
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="relative flex cursor-pointer w-full hover:dark:bg-white/10 select-none items-center rounded-sm gap-2 px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&>svg]:size-4 [&>svg]:shrink-0">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Список отчётов</DialogTitle>
                <DialogDescription>
                    Здесь вы можете посмотреть список всех отчётов по данной задаче.
                </DialogDescription>
            </DialogHeader>
            <ScrollArea :task="props.task" :reports="props.reports" />
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>