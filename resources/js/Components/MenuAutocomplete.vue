<template>
    <div>
        <div class="relative flex w-full flex-wrap items-stretch my-3">
            <input id="buscador" type="search" placeholder="Buscar" autocomplete="true"
                class="form-input px-3 py-2 placeholder-gray-400 text-gray-700 relative bg-white rounded-lg text-sm shadow outline-none focus:outline-none focus:shadow-outline w-full pr-10 border-2" style="width: 500px;" v-model="searchTerm" @input="fetchSuggestions" @focus="showSuggestions = true"
                @blur="hideSuggestions"/>
            <span
                class="z-10 h-full leading-snug font-normal  text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 right-0 pr-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -mt-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
        </div>
        <ul v-if="showSuggestions" class="absolute top-12 border bg-white mt-1 shadow-xl w-[500px] rounded-md">
            <div
                v-for="(item, index) in suggestions"
                :key="index"
                class="flex flex-col"
            >
                <span class="bg-gray-500 text-white">{{ item.nombre  }}</span>
                <NavLink  v-for="(accion, i) in item.acciones" :key="i" class="p-2 hover:bg-gray-200 cursor-pointer border-b border-b-gray-300" :href="`http://mail.tecnoweb.org.bo/inf513/grupo08sa/proyecto2/public${accion.url}`">
                    {{ accion.nombre }}
                </NavLink>
            </div>
            <div v-if="!suggestions.length">No se Encontraron resultados</div>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import NavLink from './NavLink.vue';

    const searchTerm = ref('');
    const suggestions = ref([]);
    const showSuggestions = ref(false);
    const isLoading = ref(false);
    const page = usePage()

    let cancelTokenSource = null;

    const fetchSuggestions = async () => {
        if (cancelTokenSource) {
            cancelTokenSource.cancel('Nueva solicitud iniciada');
        }

        if (searchTerm.value.trim().length > 1) {
            cancelTokenSource = axios.CancelToken.source();
            isLoading.value = true;
            showSuggestions.value = true

            try {
                const response = await axios.get('api/menu/buscar', {
                    params: { termino: searchTerm.value },
                    cancelToken: cancelTokenSource.token,
                });
                const filtered = filtrarMenus(response.data)
                suggestions.value = filtered
            } catch (error) {
                if (!axios.isCancel(error)) {
                    console.error('Error fetching suggestions:', error);
                }
            } finally {
                isLoading.value = false;
            }
        } else {
            suggestions.value = [];
        }
    };

    function filtrarMenus(menus) {
        const user = page.props.auth.user
        if(user.rol_id == 1) return menus
        const menusUsuario = user.permisos
        return menus.filter(menu => {
            return Boolean(menusUsuario.find(m => m.menu == menu.nombre))
        })
        .map(menu => {
            return {
                ...menu,
                acciones: menu.acciones.filter(acc => {
                    const menuUsuario = menusUsuario.find(m => m.menu == menu.nombre)
                    return Boolean(menuUsuario.acciones.find(a => a.id == acc.id))
                })
            }
        })
    }

    const hideSuggestions = () => {
        setTimeout(() => {
            showSuggestions.value = false;
        }, 200);
    };
</script>

<style lang="scss" scoped>

</style>
