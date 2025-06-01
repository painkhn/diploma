<script setup lang="ts">
import { Check, Search, CircleMinus, Trash2 } from 'lucide-vue-next'
import { computed, defineProps, ref } from 'vue'
import { User } from '@/types';
import Input from '@/Components/ui/input/Input.vue';
import Button from '@/Components/ui/button/Button.vue';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    users: User[],
    projectId: number
}>()

const searchQuery = ref('')
const selectedUser = ref<User | null>(null)
const showResults = ref(false)
const isLoading = ref(false)
const error = ref<string | null>(null)
const success = ref<string | null>(null)

const filteredUsers = computed(() => {
    if (!searchQuery.value) return []
    return props.users.filter(user =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
})

const selectUser = (user: User) => {
    selectedUser.value = user
    searchQuery.value = ''
    showResults.value = false
}

const unselectUser = () => {
    selectedUser.value = null
    error.value = null
    success.value = null
}

const handleInput = () => {
    showResults.value = searchQuery.value.length > 0
}

const submit123 = async () => {
    if (!selectedUser.value) return

    isLoading.value = true
    error.value = null
    success.value = null

    try {
        const response = await router.post(`/project/${props.projectId}/invitations`, {
            recipient_id: selectedUser.value.id
        })

        success.value = 'Приглашение успешно отправлено!'
        selectedUser.value = null
        searchQuery.value = ''
    } catch (err) {
        error.value = 'Произошла ошибка при отправке приглашения'
    } finally {
        isLoading.value = false
        console.log('успешно');

    }
}

const form = useForm({
    role: ''
})

const submit = () => {

}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div v-if="error"
            class="py-2 px-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-md font-semibold text-sm">
            {{ error }}
        </div>
        <div v-if="success"
            class="py-2 px-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-md font-semibold text-sm">
            {{ success }}
        </div>

        <div class="relative w-full items-center">
            <Input id="search" v-model="searchQuery" @input="handleInput" type="text" placeholder="Поиск по имени..."
                class="pl-10" autocomplete="off" />
            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                <Search class="size-6 text-muted-foreground" />
            </span>
        </div>

        <div v-if="showResults && filteredUsers.length > 0"
            class="max-h-60 w-full z-10 dark:bg-[#0c0a09] shadow-md shadow-black top-5 overflow-y-auto border rounded-md absolute">
            <ul>
                <li v-for="user in filteredUsers" :key="user.id"
                    class="px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-[#020202] cursor-pointer"
                    @click="selectUser(user)">
                    {{ user.name }}
                </li>
            </ul>
        </div>

        <div v-if="selectedUser"
            class="p-3 flex items-center justify-between bg-gray-100 dark:bg-[#0c0a09] border dark:border-white/5 rounded-md">
            <p class="font-semibold">{{ selectedUser.name }}</p>
            <button @click="unselectUser" class="transition-all hover:opacity-80">
                <Trash2 />
            </button>
        </div>
        <Button type="submit" :disabled="!selectedUser || isLoading"
            class="w-full transition-all dark:bg-white bg-black dark:text-black text-white hover:dark:bg-gray-200 hover:bg-black/80">
            <span v-if="isLoading">Отправка...</span>
            <span v-else>Отправить приглашение</span>
        </Button>
    </form>
</template>