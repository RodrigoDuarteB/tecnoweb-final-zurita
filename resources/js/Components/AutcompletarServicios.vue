<template>
    <div class="autocomplete">
        <div class="flex gap-2 items-center">
            <div>
                <InputLabel value="Buscar Servicios"/>
                <input
                    type="text"
                    v-model="searchTerm"
                    @input="fetchSuggestions"
                    @focus="showSuggestions = true"
                    @blur="hideSuggestions"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                />
            </div>
            <div v-if="isLoading" class="loader ml-2 border-2 border-gray-300 border-t-blue-500 rounded-full w-4 h-4 animate-spin"></div>
        </div>
        <ul v-if="showSuggestions && suggestions.length" class="border bg-white mt-1 shadow-xl w-[400px]">
            <li
                v-for="(item, index) in suggestions"
                :key="index"
                @mousedown.prevent="selectSuggestion(item)"
                class="p-2 hover:bg-gray-200 cursor-pointer border-b border-b-gray-300"
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
    const isLoading = ref(false);

    let cancelTokenSource = null;

    const fetchSuggestions = async () => {
        if (cancelTokenSource) {
            cancelTokenSource.cancel('Nueva solicitud iniciada');
        }

        if (searchTerm.value.trim().length > 1) {
            cancelTokenSource = axios.CancelToken.source();
            isLoading.value = true;

            try {
                const response = await axios.get('/api/servicio/buscar', {
                    params: { termino: searchTerm.value },
                    cancelToken: cancelTokenSource.token,
                });
                suggestions.value = response.data || [];
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

    const selectSuggestion = (item) => {
        showSuggestions.value = false;
        searchTerm.value = ''
        suggestions.value = []
        emit('select', item);
    };

    const hideSuggestions = () => {
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
  .loader {
    border-top-color: #3498db;
   }
</style>
