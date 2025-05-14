<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
</script>

<template>
    <Dialog>
        <DialogTrigger class="w-full">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Example notif title</DialogTitle>
                <DialogDescription>
                    <!-- Make changes to your profile here. Click save when you're done. -->
                </DialogDescription>
            </DialogHeader>
            <div class="">
                <p>
                    Example notification content
                </p>
            </div>
            <DialogFooter>
                <!-- Save changes -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>