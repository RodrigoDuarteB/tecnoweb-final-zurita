<template>
    <ManagmentLayout :title="getTitulo()">
        <form @submit.prevent="submit">
            <div class="flex gap-2">
                <div class="w-full">
                    <InputLabel for="nombre" value="Nombre"/>
                    <InputError :message="errors.nombre"/>
                    <TextInput type="text" v-model="form.nombre" id="nombre" class="mt-1 block w-full" required :disabled="disabled"/>
                </div>

                <div class="w-full">
                    <InputLabel for="descripcion" value="Descripción"/>
                    <InputError :message="errors.descripcion"/>
                    <TextInput v-model="form.descripcion" id="descripcion" class="mt-1 block w-full" :disabled="disabled"/>
                </div>
            </div>

            <div class="flex flex-col mt-2 gap-3">
                <SecondaryButton class="w-fit" @click="handleAddAction">Añadir Acción</SecondaryButton>
                <span class="font-semibold text-[1rem] border-b border-b-gray-400">Acciones</span>
                <ul v-for="(accion, index) in form.acciones.filter(acc => acc.estado == 'Activo')" :key="index">
                    <li class="flex gap-5 items-center border-b border-b-gray-400/60 pb-2">
                        <div class="w-full">
                            <InputLabel value="Nombre"/>
                            <TextInput type="text" v-model="accion.nombre" class="mt-1 block w-full" required :disabled="disabled"/>
                        </div>
                        <div class="w'full">
                            <InputLabel value="Es Menú"/>
                            <Checkbox v-model="accion.es_menu" :checked="accion.es_menu" :disabled="disabled"/>
                        </div>
                        <div class="w-full" v-if="accion.es_menu">
                            <InputLabel value="Url"/>
                            <TextInput type="text" v-model="accion.url" class="mt-1 block w-full" required :disabled="disabled"/>
                        </div>
                        <EliminarButton @click="() => handleDeleteAction(index)"  svg-class="size-6" v-if="!esVer"/>
                    </li>
                </ul>
            </div>

            <PrimaryButton v-if="!esVer" type="submit" class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ form.id ? 'Actualizar' : 'Guardar' }}
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

    function getTitulo() {
        if(menu) {
            return props.esVer ? `Ver Menú ${menu.id}` : `Editar Menú ${menu.id}`
        }
        return 'Registrar Menú'
    }

    function getAcciones() {
        if(menu) {
            return menu.acciones
        } else {
            return [
                {
                    id: null,
                    nombre: 'Listar',
                    es_menu: true,
                    url: '',
                    estado: 'Activo'
                },
                {
                    id: null,
                    nombre: 'Registrar',
                    es_menu: true,
                    url: '',
                    estado: 'Activo'
                },
                {
                    id: null,
                    nombre: 'Editar',
                    es_menu: false,
                    estado: 'Activo'
                },
                {
                    id: null,
                    nombre: 'Ver',
                    es_menu: false,
                    estado: 'Activo'
                },
                {
                    id: null,
                    nombre: 'Eliminar',
                    es_menu: false,
                    estado: 'Activo'
                }
            ]
        }
    }

    const form = useForm({
        id: menu?.id ?? null,
        nombre: menu?.nombre ?? '',
        descripcion: menu?.descripcion ?? '',
        acciones: getAcciones()
    });

    function prepareToSend(data) {
        return {
            ...data,
            acciones: data.acciones.filter(acc => {
                if(!acc.id && acc.estado == 'Inactivo') {
                    return false
                }
                return true
            })
        }
    }

    const submit = () => {
        if(menu?.id) {
            form.transform(prepareToSend).put(route('menu.update', { id: menu.id }))
        } else {
            form.transform(prepareToSend).post(route('menu.store'))
        }
    }

    function handleAddAction() {
        form.acciones.push({
            id: null,
            nombre: '',
            es_menu: true,
            url: '',
            estado: 'Activo'
        })
    }

    function handleDeleteAction(index) {
        form.acciones[index].estado = 'Inactivo'
    }

</script>

<style lang="scss" scoped>

</style>
