<template>
    <header class="z-40 py-4">
        <div class="flex items-center justify-between h-8 px-6 mx-auto">
            <!-- Mobile hamburger -->
            <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>

            <!-- Search Input -->
            <MenuAutocomplete />
            <!-- <div class="flex justify-center mt-2 mr-4">
                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                    <input id="buscador" type="search" placeholder="Buscar" autocomplete="true"
                        class="form-input px-3 py-2 placeholder-gray-400 text-gray-700 relative bg-white rounded-lg text-sm shadow outline-none focus:outline-none focus:shadow-outline w-full pr-10 border-2" style="width: 500px;"/>
                    <span
                        class="z-10 h-full leading-snug font-normal  text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 right-0 pr-3 py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -mt-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                </div>
                <div class="absolute rounded shadow bg-white overflow-hidden peer-checked:flex flex-col mt-1 border border-gray-200" style="top: 3rem; left: 16.6rem; width: 500px;" id="busquedaResultados" hidden>
                </div>
            </div> -->

            <ul class="flex items-center flex-shrink-0 space-x-6">
                <SettingsButton />
            </ul>

        </div>
    </header>
</template>

<script setup>
import MenuAutocomplete from './MenuAutocomplete.vue';
import SettingsButton from './SettingsButton.vue';


</script>

<style lang="scss" scoped>

</style>
