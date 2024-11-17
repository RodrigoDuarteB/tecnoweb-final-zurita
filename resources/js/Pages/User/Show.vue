<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

// Definimos las props si es necesario recibir datos desde el padre
const props = defineProps(['user']);

// Inicializamos el formulario con los datos predefinidos
const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: props.user?.password ||'',
    current_team_id: props.user?.current_team_id ||'',
});
</script>

<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mostrar Usuario
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <InputLabel for="name" value="Nombre"/>
                            <TextInput type="text" v-model= "form.name"  id="name" class="mt-1 block w-full" readonly />

                            <InputLabel for="email" value="Email"/>
                            <TextInput type="email" v-model="form.email" id="email" class="mt-1 block w-full" readonly />

                            <InputLabel for="password" value="Contraseña"/>
                            <TextInput type="password" v-model="form.password" id="password" class="mt-1 block w-full" readonly />

                            <InputLabel for="current_team_id" value="Team"/>
                            <TextInput type="text" v-model="form.current_team_id" id="current_team_id" class="mt-1 block w-full" readonly/>

                            <Link :href="route('user.index')" class="btn btn-primary mr-2 inline-block mt-1 block">
                               Volver
                            </Link>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
