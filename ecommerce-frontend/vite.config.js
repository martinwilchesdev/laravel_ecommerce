import { fileURLToPath, URL } from 'node:url'

import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig(({mode}) => {
	const env = loadEnv(mode, process.cwd())
	const API_URL = `${env.VITE_API_BASE_URL ?? 'http://localhost:8000'}`

	return {
		plugins: [vue(), vueDevTools(), tailwindcss()],
		resolve: {
			alias: {
				'@': fileURLToPath(new URL('./src', import.meta.url)),
			},
		},
		server: {
			proxy: {
				'/api': {
					target: API_URL,
					changeOrigin: true,
				},
			},
		},
	}
})
