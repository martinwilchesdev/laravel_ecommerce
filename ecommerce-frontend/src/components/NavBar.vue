<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'

// store de pinia `auth`
import { useAuthStore } from '@/stores/auth'

// enrutador `vue-router`
import { useRouter } from 'vue-router'

// instancia de la store de pinia
const authStore = useAuthStore()

// instancia del enrutador
const router = useRouter()

// cerrar la sesion del usuario actual
const logout = async () => {
    await authStore.logout()
    router.push({ name: 'login' })
}
</script>

<template>
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl text-emerald-500 font-bold">e-commerce</h1>

        <Menu as="div" class="relative inline-block text-left">
            <div>
                <MenuButton
                    class="inline-flex w-full justify-center items-center rounded-md px-4 py-2 text-md font-medium text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
                >
                    {{ authStore.user.name }}
                    <ChevronDownIcon
                        class="-mr-1 ml-2 h-5 w-5"
                        aria-hidden="true"
                    />
                </MenuButton>
            </div>

            <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <MenuItems
                    class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                >
                    <div class="px-1 py-1">
                        <MenuItem>
                            <span
                                class="group flex w-full items-center rounded-md px-2 py-2 text-sm"
                                >{{ authStore.user.email }}</span
                            >
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                            <button
                                :class="[
                                    active
                                        ? 'bg-emerald-500 text-white transition'
                                        : 'text-gray-900',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                ]"
                                @click="logout"
                            >
                                Cerrar sesión
                            </button>
                        </MenuItem>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
    </nav>
</template>
