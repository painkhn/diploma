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
import { ref, computed, nextTick } from 'vue';
import { Input } from '@/Components/ui/input'
import { CircleMinus, Search, Trash2 } from 'lucide-vue-next'
import { Button } from '@/Components/ui/button'
import { User } from '@/types';

const props = defineProps<{
    users: User[]
}>()

const searchQuery = ref('')
const selectedUser = ref<User | null>(null)
const showResults = ref(false)

const filteredUsers = computed(() => {
    if (!searchQuery.value) return []
    return props.users.filter(user =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
})

const selectUser = (user: User) => {
    selectedUser.value = user
    searchQuery.value = user.name
    showResults.value = false // Скрываем результаты после выбора
}

const unselectUser = () => {
    selectedUser.value = null
}

const handleInput = () => {
    showResults.value = searchQuery.value.length > 0
}

const submitForm = () => {
    if (!selectedUser.value) return

    console.log('Отправка пользователя:', selectedUser.value)
    // Ваш код для отправки на сервер

    // Сброс состояния
    selectedUser.value = null
    searchQuery.value = ''
    showResults.value = false
}
</script>

<template>
    <Dialog>
        <DialogTrigger
            class="w-full flex items-center gap-x-2 py-2 justify-center rounded-md transition-all hover:dark:bg-white/5">
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Пригласить пользователя</DialogTitle>
                <DialogDescription>
                    Найдите пользователя по его имени пользователя, чтобы отправить ему приглашение.
                </DialogDescription>
            </DialogHeader>
            <div class="relative">
                <form @submit.prevent="submitForm">
                    <div class="relative w-full items-center mb-4">
                        <Input id="search" v-model="searchQuery" @input="handleInput" type="text"
                            placeholder="Поиск по имени..." class="pl-10" autocomplete="off" />
                        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                            <Search class="size-6 text-muted-foreground" />
                        </span>
                    </div>

                    <div v-if="showResults && filteredUsers.length > 0"
                        class="max-h-60 w-full z-10 dark:bg-[#0c0a09] shadow-md shadow-black top-10 overflow-y-auto border rounded-md absolute">
                        <ul>
                            <li v-for="user in filteredUsers" :key="user.id"
                                class="px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-[#020202] cursor-pointer"
                                @click="selectUser(user)">
                                {{ user.name }}
                            </li>
                        </ul>
                    </div>

                    <div v-if="selectedUser"
                        class="mt-4 p-3 flex items-center justify-between bg-gray-100 dark:bg-[#0c0a09] border dark:border-white/5 rounded-md">
                        <p class="font-semibold">{{ selectedUser.name }}</p>
                        <button @click="unselectUser" class="transition-all hover:opacity-80">
                            <Trash2 />
                        </button>
                    </div>
                </form>
            </div>
            <DialogFooter>
                <Button type="submit" @click="submitForm" :disabled="!selectedUser"
                    class="w-full transition-all bg-white text-black hover:bg-gray-200">
                    Отправить приглашение
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>