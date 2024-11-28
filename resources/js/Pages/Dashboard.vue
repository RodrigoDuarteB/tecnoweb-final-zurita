<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
    const page = usePage()
    const esCliente = page.props.auth.user.rol_id == 2
    console.log(esCliente);
</script>

<template>
    <ManagmentLayout title="Inicio">
        <span class="font-semibold text-[1.2rem]">
            {{ `Bienvenido! ${$page.props.auth.user.name}` }}
        </span>
        <div v-if="esCliente" class="flex justify-center gap-6 mt-8">
            <Link :href="route('pago.create')">
                <PrimaryButton>Pagar</PrimaryButton>
            </Link>
            <Link :href="route('pago.index')">
                <PrimaryButton>Ir a Mis Pagos</PrimaryButton>
            </Link>
            <Link :href="route('politica.index')">
                <PrimaryButton>Ver Políticas</PrimaryButton>
            </Link>
        </div>
    </ManagmentLayout>
</template>
