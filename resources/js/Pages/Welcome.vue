<script setup>
import { Head, Link } from '@inertiajs/vue3';

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

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <div :class="['font-sans leading-normal tracking-normal h-screen', $page.props.styles.background]">
        <nav class="p-2 mt-0 w-full">
            <div class="container mx-auto flex flex-wrap items-center">
                <div class="flex w-full md:w-1/2 justify-center md:justify-start text-white font-extrabold">
                    <a class="text-white no-underline hover:text-white hover:no-underline" href="#">
                        <span class="text-2xl pl-2">Gestion de Pagos Gobernación Rurrenabaque</span>
                    </a>
                </div>
                <div class="flex w-full pt-2 content-center justify-between md:w-1/2 md:justify-end">
                    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                        <Link :href="route('register')" :class="['no-underline hover:text-gray-200 hover:text-underline py-2 px-4', $page.props.styles.textos]">Registrarse</Link>
                        <Link :href="route('login')" :class="['no-underline hover:text-gray-200 hover:text-underline py-2 px-4', $page.props.styles.textos]">Ingresar</Link>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mx-auto flex flex-col md:flex-row items-center my-12 md:my-24">
            <div class="w-full lg:w-1/2 lg:py-6 text-center">
                <img src="{{ asset('images/ficct.jpg') }}" alt="" style="opacity: 0.7;">
            </div>
        </div>

        <p :class="['text-right font-bold text-sm mr-4 mb-2', $page.props.styles.textos]">
            Visitas: 0
        </p>
    </div>
</template>
