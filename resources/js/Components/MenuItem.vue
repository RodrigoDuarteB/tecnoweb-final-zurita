<template>
    <li class="relative px-2 py-1">
        <div class="inline-flex items-center justify-between w-full text-base font-semibold transition-colors duration-150 text-gray-500 hover:text-yellow-400 cursor-pointer" @click="toggleOpen">
            <span :class="['inline-flex items-center text-sm font-semibold', styles.textos]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
                <span class="ml-4">{{ menu.menu }}</span>
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" v-show="!opened" :class="['ml-1 w-4 h-4', styles.textos]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 19l-7-7 7-7" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" v-show="opened"
            :class="['ml-1 w-4 h-4', styles.textos]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <div v-if="menu.acciones.length && opened">
            <ul :class="['p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium rounded-md shadow-inner', styles.fondo]" aria-label="submenu">
                <li class="px-2 py-1 text-white transition-colors duration-150" v-for="(accion, index) in menu.acciones.filter(m => m.es_menu)" :key="index">
                    <!-- :href="`http://mail.tecnoweb.org.bo/inf513/grupo08sa/proyecto2/public${accion.url}`" -->
                    <NavLink
                        :href="accion.url"
                        :class="['w-full px-1 hover:text-gray-800 hover:bg-gray-100 rounded-md', page.url == accion.url ? '!text-gray-800 !bg-gray-100' : '']"
                    >
                        <div class="flex items-center hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <div :class="['w-full ml-2 text-sm font-semibold text-white hover:text-gray-800', page.url == accion.url ? '!text-gray-800' : '']">
                                {{ accion.nombre }}
                            </div>
                        </div>
                    </NavLink>
                </li>
            </ul>
        </div>
    </li>

</template>

<script setup>
import { ref } from 'vue';
import NavLink from './NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import { getTimeStyles } from '@/utils';

    const page = usePage()

    const props = defineProps(['menu'])

    const opened = ref(props.menu.acciones.some(accion => accion.es_menu && accion.url == page.url))

    function toggleOpen() {
        opened.value =!opened.value;
    }
    const styles = getTimeStyles()
</script>

<style lang="scss" scoped>

</style>
