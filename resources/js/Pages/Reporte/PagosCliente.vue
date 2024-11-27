<template>
    <ManagmentLayout title="Reporte Pagos por Cliente">
        <form @submit.prevent="submit" class="flex gap-3 items-center">
            <div class="my-2">
                <InputLabel value="Cliente"/>
                <Select :items="getClientes()" v-model="datos.cliente_id"/>
            </div>

            <div class="w-full">
                <InputLabel for="fecha_inicio" value="Fecha Inicio"/>
                <TextInput v-model="datos.fecha_inicio" id="fecha_inicio" class="mt-1 block w-full" type="date" required/>
            </div>

            <div class="w-full">
                <InputLabel for="fecha_fin" value="Fecha Fin"/>
                <TextInput v-model="datos.fecha_fin" id="fecha_fin" class="mt-1 block w-full" type="date" required/>
            </div>

            <PrimaryButton type="submit" class="mt-4">
                Generar
            </PrimaryButton>
        </form>

        <div v-if="items">

        </div>
    </ManagmentLayout>
</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Select from '@/Components/Select.vue';
import TextInput from '@/Components/TextInput.vue';
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { hideLoading, showLoading } from '@/state';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
    const props = defineProps(['clientes'])

    const datos = useForm({
        cliente_id: null,
        fecha_inicio: null,
        fecha_fin: null
    })
    const items = ref(null)

    function getClientes() {
        return props.clientes.map(cl => {
            return {
                value: cl.id,
                label: `${cl.usuario.name} - ${cl.carnet_identidad}`
            }
        })
    }

    function submit() {
        console.log(datos.data())
        showLoading()
        axios.get('/api/reporte/pagosPorCliente', {
            params: datos.data()
        })
        .then(res => {
            console.log(res.data)
        })
        .finally(() => {
            hideLoading()
        })
    }

</script>

<style lang="scss" scoped>

</style>
