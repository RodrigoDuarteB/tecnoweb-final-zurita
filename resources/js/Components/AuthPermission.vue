<template>
    <template v-if="visible">
        <slot />
    </template>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { userHasAccion } from '../utils'

    const page = usePage()
    const props = defineProps(['menu', 'accion'])

    const visible = userHasAccion({
        permisos: page.props.auth.user.permisos,
        menu: props.menu,
        accion: props.accion
    })
    console.log(visible);
</script>

<style lang="scss" scoped>

</style>
