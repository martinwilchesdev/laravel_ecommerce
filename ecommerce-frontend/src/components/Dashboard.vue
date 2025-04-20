<script setup>
import { useAuthStore } from '@/stores/auth'
import { useRouter} from 'vue-router'

const authStore = useAuthStore()

const router = useRouter()

const logout = async () => {
    await authStore.logout()
    router.push({ name: 'login' })
}
</script>

<template>
    <div>
        <button @click="logout">Logout</button>
    </div>
</template>
