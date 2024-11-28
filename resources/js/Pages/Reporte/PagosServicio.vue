<template>
    <ManagmentLayout title="Reporte Pagos por Servicio">
        <form @submit.prevent="submit" class="flex gap-3 items-center">
            <div class="my-2">
                <InputLabel value="Servicio"/>
                <Select :items="getServicios()" v-model="datos.servicio_id" required/>
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

        <div v-if="items" class="flex flex-col gap-3 mt-3">
            <span>Resultados</span>
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-center">Id</th>
                        <th class="py-3 px-6 text-center">Cliente</th>
                        <th class="py-3 px-6 text-center">Fecha Hora</th>
                        <th class="py-3 px-6 text-center">Fecha Hora Confirmación </th>
                        <th class="py-3 px-6 text-center">Servicios</th>
                        <th class="py-3 px-6 text-center">Total Descuento</th>
                        <th class="py-3 px-6 text-center">Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="item in items" :key="item">
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.id }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.cliente }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.fecha_hora }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.fecha_hora_confirmacion }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.servicios }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.total_descuento }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.total }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <span v-if="!items.length" class="text-center">No hay Datos para Mostrar</span>
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
    const props = defineProps(['servicios'])

    const datos = useForm({
        servicio_id: null,
        fecha_inicio: null,
        fecha_fin: null
    })
    const items = ref(null)

    function getServicios() {
        return props.servicios.map(srv => {
            return {
                value: srv.id,
                label: srv.nombre
            }
        })
    }

    function submit() {
        if(new Date(datos.fecha_fin) < new Date(datos.fecha_inicio)) return alert("La fecha inicio debe ser menor o igual a la fecha fin")
        items.value = null
        showLoading()
        axios.get('public/api/reporte/pagosPorServicio', {
            params: datos.data()
        })
        .then(res => {
            items.value = res.data
        })
        .finally(() => {
            hideLoading()
        })
    }

</script>

<style lang="scss" scoped>

</style>
