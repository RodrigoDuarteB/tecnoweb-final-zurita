<template>
    <div :class="['flex h-screen w-full', `${$page.props.styles.background}-${tema}`]">
        <Menu />

        <div class="flex flex-col flex-1 w-full">
            <Header />
            <main>
                <div class="rounded-3xl bg-gray-100 border-4 py-5 mr-3 mb-3 altura overflow-y-auto overflow-x-auto ancho" style="padding-left: 1.25rem; padding-right: 1.25rem;">
                    <header v-if="$slots.header" class="shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </header>
                    <slot />
                    <p class="text-right font-bold text-sm mt-4">Visitas: {{ $page.props.conteoPagina }}</p>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    import Header from '@/Components/Header.vue';
    import { usePage } from '@inertiajs/vue3';
    console.log(usePage().props);
    const tema = localStorage.getItem('tema') ?? 'adultos'
</script>

<style lang="scss" scoped>

</style>
