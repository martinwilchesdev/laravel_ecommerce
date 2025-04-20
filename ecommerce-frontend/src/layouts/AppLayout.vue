<script setup>
import NavBar from '@/components/NavBar.vue'
</script>

<template>
    <div class="min-h-screen bg-gray-100">
		<!-- navbar comun para todas las paginas con sesion activa -->
        <NavBar />

		<!-- contenido dinamico segun la ruta actual -->
		<main class="p-4">
			<slot />
		</main>
    </div>
</template>
