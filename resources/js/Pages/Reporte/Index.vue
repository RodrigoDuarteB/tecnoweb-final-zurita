<template>
    <ManagmentLayout title="Reportes">
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
    </ManagmentLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<style lang="scss" scoped>

</style>
