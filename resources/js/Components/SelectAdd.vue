<template>
    <div class="flex gap-3">
        <Select v-model="selectedValue" :items="items" />
        <SecondaryButton class="w-fit" @click="emitSelection">
            {{ buttonLabel }}
        </SecondaryButton>
    </div>
  </template>

<script setup>
import { ref } from 'vue';
import Select from './Select.vue';
import SecondaryButton from './SecondaryButton.vue';

    // Props definition
    defineProps({
        items: {
            type: Array,
            required: true,
            default: () => [],
        },
        buttonLabel: {
            type: String,
            required: true,
            default: 'Añadir',
        }
    });

    // Emit event
    const emit = defineEmits(['selected']);

    // State
    const selectedValue = ref(null);

    // Emit the selected value
    const emitSelection = () => {
        emit('selected', selectedValue.value);
    };
</script>
