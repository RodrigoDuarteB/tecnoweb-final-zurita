<template>
    <ManagmentLayout title="Registrar Menú">
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
                        <EliminarButton @click="() => handleDeleteAction(index)"  svg-class="size-6"/>
                    </li>
                </ul>
            </div>

            <PrimaryButton type="submit" class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Enviar
            </PrimaryButton>
        </form>
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
import EliminarButton from '@/Components/EliminarButton.vue';

    const props = defineProps(['errors', 'menu', 'esVer']);
    const menu = props.menu
    const disabled = props.esVer ? true : false

    const form = useForm({
        nombre: menu?.nombre ?? '',
        descripcion: menu?.descripcion ?? '',
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
