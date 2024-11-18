<template>
    <aside class="z-20 flex-shrink-0 hidden w-60 pl-2 md:block overflow-y-auto">
        <div>
            <div class="text-white">
                <div class="flex p-2">
                    <a class="flex flex-col py-3 px-2 items-center" href="">
                        <p :class="['text-2xl font-semibold', $page.props.styles.titulo]">
                            Gobernacion
                        </p>
                        <p :class="['ml-2 font-semibold italic', $page.props.styles.textos]">
                            Rurrenabaque
                        </p>
                    </a>
                </div>
                <div class="flex justify-center">
                    <div class="">
                        <img class="hidden h-24 w-24 rounded-full sm:block object-cover mr-2 border-4"
                            src="" alt="">
                        <p class="font-bold text-base {{ config('styles.general.textos') }} pt-2 text-center w-24">{{ $page.props.auth.user.name }}</p>
                    </div>
                </div>
                <div>
                    <ul class="mt-6 leading-10" v-for="(menu, index) in menus" :key="index">
                        <MenuItem :menu="menu" />
                    </ul>
                </div>
            </div>
        </div>
    </aside>

</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import MenuItem from './MenuItem.vue';

    const { url } = usePage()

    console.log(url)

    const menus = [
        {
            nombre: 'Gestionar Usuarios',
            acciones: [
                {
                    esMenu: true,
                    nombre: 'Listar Usuarios',
                    ruta: '/dashboard/user',
                    activa: true
                },
                {
                    esMenu: true,
                    nombre: 'Registrar Usuario',
                    ruta: '/dashboard/user/create',
                    activa: false
                },
                {
                    esMenu: false,
                    nombre: 'Eliminar Usuario',
                    ruta: 'usuarios/eliminar'
                }
            ]
        }
    ]
</script>

<style lang="scss" scoped>

</style>
