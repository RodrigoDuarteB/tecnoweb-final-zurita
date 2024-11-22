<template>
    <div :class="['flex h-screen w-full', `${$page.props.styles.background}-${tema}`]">
        <Menu />

        <div class="flex flex-col flex-1 w-full">
            <Header />
            <main>
                <div class="rounded-3xl bg-gray-100 border-4 py-5 mr-3 mb-3 altura overflow-y-auto overflow-x-auto ancho flex flex-col" style="padding-left: 1.25rem; padding-right: 1.25rem;">
                    <div class="shadow mb-6">
                        <span class="text-[2rem] font-semibold">{{ title }}</span>
                    </div>
                    <Card>
                        <slot />
                    </Card>
                    <p class="text-right font-bold text-sm mt-4 text-[1.2rem]">
                        Visitas: {{ $page.props.conteoPagina }}
                    </p>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import Menu from '@/Components/Menu.vue';
import Header from '@/Components/Header.vue';
import { usePage } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
    console.log(usePage().props);
    const tema = localStorage.getItem('tema') ?? 'adultos'

    const props = defineProps(['title'])
</script>

<style lang="scss" scoped>

</style>
