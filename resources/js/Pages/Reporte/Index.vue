<template>
    <ManagmentLayout title="Reportes y Estadísticas">
        <div class="flex flex-col gap-4">
            <div class="w-full px-4 py-8 bg-blue-400 flex justify-between rounded-md shadow-md">
                <span class="text-white font-semibold text-[1.2rem]">Pagos por Cliente en Rango de Fechas</span>
                <Link :href="route('reporte.pagosPorCliente')">
                    <PrimaryButton>Ver</PrimaryButton>
                </Link>
            </div>

            <div class="w-full px-4 py-8 bg-blue-400 flex justify-between rounded-md shadow-md">
                <span class="text-white font-semibold text-[1.2rem]">Pagos por Servicio en Rango de Fechas</span>
                <Link :href="route('reporte.pagosPorServicio')">
                    <PrimaryButton>Ver</PrimaryButton>
                </Link>
            </div>

            <div class="w-full px-4 py-8 bg-blue-400 flex justify-between rounded-md shadow-md">
                <span class="text-white font-semibold text-[1.2rem]">Total Pagos y Descuentos en Rango de Fechas</span>
                <Link :href="route('reporte.totalPagos')">
                    <PrimaryButton>Ver</PrimaryButton>
                </Link>
            </div>
        </div>
        <div class="flex flex-col items-center mt-8">
            <span class="font-semibold text-[1.2rem]">Páginas mas visitadas</span>
            <div class="size-[400px]">
                <Doughnut :data="getChartData()" />
            </div>
        </div>
    </ManagmentLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
    ChartJS.register(ArcElement, Tooltip, Legend)
    const props = defineProps(['contadores'])

    function getChartData() {
        return {
            labels: props.contadores.map(c => c.ruta),
            datasets: [{
                data: props.contadores.map(c => c.conteo),
                backgroundColor: ['#41B883', '#E46651', '#00D8FF'],
            }]
        }
    }
</script>

<style lang="scss" scoped>

</style>
