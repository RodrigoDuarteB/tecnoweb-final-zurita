<script setup>
import { getTimeStyles } from '@/utils';
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

    const styles = getTimeStyles()
</script>

<template>
    <div :class="['font-sans leading-normal tracking-normal h-screen', styles.background]">
        <nav class="p-2 mt-0 w-full">
            <div class="container mx-auto flex flex-wrap items-center">
                <div class="flex w-full md:w-1/2 justify-center md:justify-start text-white font-extrabold">
                    <a class="text-white no-underline hover:text-white hover:no-underline" href="#">
                        <span :class="['text-2xl pl-2', styles.textos]">Gestion de Pagos GAM Rurrenabaque</span>
                    </a>
                </div>
                <div class="flex w-full pt-2 content-center justify-between md:w-1/2 md:justify-end">
                    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                        <Link :href="route('register')" :class="['no-underline hover:text-gray-200 hover:text-underline py-2 px-4 text-white']">
                            Registrarse
                        </Link>
                        <Link :href="route('login')" :class="['no-underline hover:text-gray-200 hover:text-underline py-2 px-4 text-white']">
                            Ingresar
                        </Link>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="flex justify-center items-center mt-40 gap-10 ml-40">
            <span class="text-white text-[2rem]">Bienvenido al Sistema de Pagos de</span>
            <img src="http://mail.tecnoweb.org.bo/inf513/grupo21sa/proyecto2/public/images/logo.png" class="bg-white w-[500px]"/>
        </div>
    </div>
</template>
