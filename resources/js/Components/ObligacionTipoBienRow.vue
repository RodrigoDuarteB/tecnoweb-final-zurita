<template>
    <div class="flex gap-3 w-full">
        <div class="w-full">
            <InputLabel for="nombre" value="Nombre"/>
            <!-- <InputError :message="errors.nombre"/> -->
            <TextInput type="text" v-model="item.nombre" id="nombre" class="mt-1 block w-full" required />
        </div>
       <div class="w-full">
            <InputLabel for="tipo" value="Tipo"/>
            <!-- <InputError :message="errors.tipo_bien_id"/> -->
            <Select v-model="item.tipo" id="tipo" class="mt-1 block w-full" :items="tipoItems" required/>
        </div>
       <div class="w-full">
            <InputLabel for="frecuencia" value="Frecuencia"/>
            <!-- <InputError :message="errors.tipo_bien_id"/> -->
            <Select v-model="item.frecuencia" id="frecuencia" class="mt-1 block w-full" :items="frecuenciaItems" required/>
        </div>
        <div class="w-full">
            <InputLabel for="precio" value="Monto"/>
            <!-- <InputError :message="errors.nombre"/> -->
            <TextInput type="number" v-model="item.precio" id="precio" class="mt-1 block w-full" required />
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, defineModel } from 'vue';
import TextInput from './TextInput.vue';
import InputLabel from './InputLabel.vue';
import InputError from './InputError.vue';
import Select from './Select.vue';
    interface Item {
        id: number;
        nombre: string;
        tipo: string;
        frecuencia: string;
        precio: number;
    }

    interface Props {
        item: Item;
    }

    const props = defineProps<Props>();
    const emit = defineEmits(['update']);

    const tipoItems = [
        { label: 'Impuesto', value: 'Impuesto' },
        { label: 'Tasa', value: 'Tasa' },
        { label: 'Multa', value: 'Multa' },
        { label: 'Otro', value: 'Otro' },
    ]

    const frecuenciaItems = [
        { label: 'Diaria', value: 'Diaria' },
        { label: 'Semanal', value: 'Semanal' },
        { label: 'Quincenal', value: 'Quincenal' },
        { label: 'Mensual', value: 'Mensual' },
        { label: 'Anual', value: 'Anual' },
        { label: 'UnaVez', value: 'UnaVez' },
    ]

    const actualizarItem = (key: string, value: any) => {
        // Modificar la prop item aquí
        const nuevoItem = { ...props.item, [key]: value };
        emit('update', nuevoItem);
    };
</script>

<style lang="scss" scoped>

</style>
