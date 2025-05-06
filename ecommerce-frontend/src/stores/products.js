import { api } from '@/resources/js/axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useProductStore = defineStore('products', () => {
    const products = ref([]) // lista de productos
	const categories = ref([]) // categorias de los productos
    const filters = ref({
        // filtros activos
        busqueda: '',
        categoria_id: null,
        precio_minimo: null,
        precio_maximo: null,
    })
    const pagination = ref({
        // informacion de paginacion
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
    })

    // cargar productos desde la API
    async function fetchProducts(page = 1) {
        try {
			// los filtros son enviados como parametros en la peticion HTTP `GET`
            const response = await api.get('/products', {
                params: {
                    ...filters.value,
                    page,
                },
            })

			// se actualizan los productos y la paginacion
            products.value = response.data.data
			pagination.value = {
				current_page: response.data.current_page,
				last_page: response.data.last_page,
				per_page: response.data.per_page,
				total: response.data.total
			}
        } catch (e) {
            console.log('Error al cargar los productos: ', e)
        }
    }

	// obtener categorias
	async function fetchCategories() {
		try {
			const response = await api.get('/categories')
			categories.value = response.data
		} catch(e) {
			console.log('Error al cargar las categorias de los productos: ', e)
		}
	}

	// actualizar un filtro especifico
	function updateFilter(key, value) {
		filters.value[key] = value
	}

	// limpiar los filtros
	function resetFilters() {
		filters.value = {
			search: '',
			categoria_id: null,
			precio_minimo: null,
			precio_maximo: null
		}
	}

    return {
        products,
		categories,
        filters,
        pagination,
        fetchProducts,
		fetchCategories,
		updateFilter,
		resetFilters
    }
})
