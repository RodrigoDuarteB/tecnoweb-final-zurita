<template>
    <ManagmentLayout title="Reporte Total Pagos y Descuentos">
        <form @submit.prevent="submit" class="flex gap-3 items-center">
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
                        <th class="py-3 px-6 text-center">Total</th>
                        <th class="py-3 px-6 text-center">Total Descuento</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="item in items" :key="item">
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.total ?? 0 }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ item.total_descuento ?? 0 }}
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
import TextInput from '@/Components/TextInput.vue';
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { hideLoading, showLoading } from '@/state';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

    const datos = useForm({
        fecha_inicio: null,
        fecha_fin: null
    })
    const items = ref(null)

    function submit() {
        if(new Date(datos.fecha_fin) < new Date(datos.fecha_inicio)) return alert("La fecha inicio debe ser menor o igual a la fecha fin")
        items.value = null
        showLoading()
        axios.get('http://mail.tecnoweb.org.bo/inf513/grupo08sa/proyecto2/public/api/reporte/totalPagosYDescuentos', {
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
