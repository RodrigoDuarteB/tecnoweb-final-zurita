<template>
    <div class="autocomplete">
        <InputLabel value="Buscar Servicios"/>
        <input
            type="text"
            v-model="searchTerm"
            @input="fetchSuggestions"
            @focus="showSuggestions = true"
            @blur="hideSuggestions"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        />
        <ul v-if="showSuggestions && suggestions.length" class="border bg-white w-full mt-1">
            <li
                v-for="(item, index) in suggestions"
                :key="index"
                @mousedown.prevent="selectSuggestion(item)"
                class="p-2 hover:bg-gray-200 cursor-pointer"
            >
            {{ item.nombre }}
            </li>
        </ul>
    </div>
  </template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import InputLabel from './InputLabel.vue';

    const emit = defineEmits(['select']);
    const searchTerm = ref('');
    const suggestions = ref([]);
    const showSuggestions = ref(false);

    const fetchSuggestions = async () => {
        if (searchTerm.value.trim().length > 0) {
        try {
            const response = await axios.get('/api/servicio/buscar', {
            params: { termino: searchTerm.value },
            });
            suggestions.value = response.data || [];
        } catch (error) {
            console.error('Error fetching suggestions:', error);
        }
        } else {
        suggestions.value = [];
        }
    };

    const selectSuggestion = (item) => {
        // Emitimos el evento con el valor seleccionado
        showSuggestions.value = false;
        searchTerm.value = item.nombre; // Puedes ajustar según tu estructura de datos
        emit('select', item);
    };

    const hideSuggestions = () => {
        // Espera para evitar conflictos con @mousedown en los ítems
        setTimeout(() => {
        showSuggestions.value = false;
        }, 200);
    };
</script>

<style scoped>
  .autocomplete {
    position: relative;
  }
  ul {
    position: absolute;
    z-index: 10;
  }
</style>
