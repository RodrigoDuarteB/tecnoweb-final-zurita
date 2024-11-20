<template>
    <ManagmentLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Usuario
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                        <form @submit.prevent="submit">
                            <div class="flex gap-2">
                                <div class="w-full">
                                    <InputLabel for="nombre" value="Nombre"/>
                                    <InputError :message="errors.nombre"/>
                                    <TextInput type="text" v-model="form.nombre" id="nombre" class="mt-1 block w-full" required />
                                </div>

                                <div class="w-full">
                                    <InputLabel for="descripcion" value="Descripción"/>
                                    <InputError :message="errors.descripcion"/>
                                    <TextInput v-model="form.descripcion" id="descripcion" class="mt-1 block w-full" />
                                </div>
                            </div>

                            <div class="flex flex-col mt-2 gap-3">
                                <SecondaryButton class="w-fit" @click="handleAddAction">Añadir Acción</SecondaryButton>
                                <span class="font-semibold text-[1rem] border-b border-b-gray-400">Acciones</span>
                                <ul v-for="(accion, index) in form.acciones" :key="index">
                                    <li class="flex gap-5 items-center border-b border-b-gray-400/60 pb-2">
                                        <div class="w-full">
                                            <InputLabel value="Nombre"/>
                                            <TextInput type="text" v-model="accion.nombre" class="mt-1 block w-full" required />
                                        </div>
                                        <div class="w'full">
                                            <InputLabel value="Es Menú"/>
                                            <Checkbox v-model="accion.es_menu" :checked="accion.es_menu"/>
                                        </div>
                                        <div class="w-full" v-if="accion.es_menu">
                                            <InputLabel value="Url"/>
                                            <TextInput type="text" v-model="accion.url" class="mt-1 block w-full" required />
                                        </div>
                                        <button type="button" class="btn btn-danger inline-block" @click="() => handleDeleteAction(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 float-left">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <PrimaryButton type="submit" class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Enviar
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </ManagmentLayout>
</template>

<script setup>
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

    // Definimos las props si es necesario recibir datos desde el padre
    const props = defineProps(['errors']);

    //const current_team_id = $page.props.auth.user.current_team_id;

    // Inicializamos el formulario con los datos predefinidos
    const form = useForm({
        nombre: '',
        descripcion: '',
        acciones: [
            {
                nombre: 'Listar',
                es_menu: true,
                url: ''
            },
            {
                nombre: 'Registrar',
                es_menu: true,
                url: ''
            },
            {
                nombre: 'Editar',
                es_menu: false,
            },
            {
                nombre: 'Ver',
                es_menu: false
            },
            {
                nombre: 'Eliminar',
                es_menu: false
            }
        ]
    });

    // Función para manejar el envío del formulario
    const submit = () => {
        console.log(form);
        form.post(route('menu.store'));
    };

    function handleAddAction() {
        form.acciones.push({
            nombre: '',
            es_menu: true,
            url: ''
        })
    }

    function handleDeleteAction(index) {
        form.acciones.splice(index, 1);
    }

</script>

<style lang="scss" scoped>

</style>
