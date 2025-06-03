<template>
    <aside class="z-20 flex-shrink-0 hidden w-60 pl-2 md:block overflow-y-auto">
        <div>
            <div class="text-white">
                <div class="flex p-2">
                    <Link class="flex flex-col py-3 px-2 items-center" :href="route('dashboard')">
                        <p :class="['text-2xl font-semibold', styles.titulo]">
                            Gestion de Pagos
                        </p>
                        <p :class="['ml-2 font-semibold italic', styles.textos]">
                            GAM Rurrenabaque
                        </p>
                    </Link>
                </div>
                <div class="flex justify-center">
                    <div class="">
                        <img class="hidden h-24 w-24 rounded-full sm:block object-cover mr-2 border-4" src="/images/user.jpg" alt="">
                        <p :class="['font-bold text-base pt-2 text-center w-24', styles.textos]">{{ $page.props.auth.user.name }}</p>
                    </div>
                </div>
                <ul class="flex flex-col gap-3 leading-10 mt-3" v-for="(menu, index) in $page.props.auth.user.permisos" :key="index">
                    <MenuItem :menu="menu" />
                </ul>
            </div>
        </div>
    </aside>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import MenuItem from './MenuItem.vue';
import { getTimeStyles } from '@/utils';
    const styles = getTimeStyles()
</script>

<style lang="scss" scoped>

</style>
