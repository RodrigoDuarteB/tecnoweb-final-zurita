<template>
    <ManagmentLayout>
        <div>
            <div class="flex space-x-4 p-4">
                <div class="form-check flex flex-column">
                    <!-- <Checkbox :checked="tema == 'niños'" id="niños" name="tema[]"/> -->
                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="tema" id="niños" value="niños" v-model="tema">
                    <InputLabel for="niños" value="Niños"/>
                </div>
                <div class="form-check flex flex-column">
                    <!-- <Checkbox :checked="tema == 'jovenes'" id="jovenes" name="tema[]"/> -->
                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="tema" id="jovenes" value="jovenes" v-model="tema">
                    <InputLabel for="jovenes" value="Jovenes" />
                </div>
                <div class="form-check flex flex-column">
                    <!-- <Checkbox :checked="tema == 'adultos'" id="adultos" name="tema[]"/> -->
                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="tema" id="adultos" value="adultos" v-model="tema">
                    <InputLabel for="adultos" value="Adultos" />
                </div>
            </div>
            <div class="px-4 py-3 text-right sm:px-6">
                <button class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="handleClick">
                    Guardar Configuracion
                </button>
            </div>
        </div>
    </ManagmentLayout>
</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { ref } from 'vue';

    const tema = ref(localStorage.getItem('tema') ?? 'adultos')

    function handleClick() {
        localStorage.setItem('tema', tema.value);
        window.location.reload();
    }
</script>

<style lang="scss" scoped>

</style>
