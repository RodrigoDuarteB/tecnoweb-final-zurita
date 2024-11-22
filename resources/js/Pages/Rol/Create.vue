<template>
    <ManagmentLayout :title="getTitulo()">
        <form @submit.prevent="submit" class="flex flex-col">
            <div class="flex gap-2">
                <div class="w-full">
                    <InputLabel for="nombre" value="Nombre"/>
                    <InputError :message="errors.nombre"/>
                    <TextInput type="text" v-model="form.nombre" id="nombre" class="mt-1 block w-full" required :disabled="!editable"/>
                </div>

                <div class="w-full">
                    <InputLabel for="descripcion" value="Descripción"/>
                    <InputError :message="errors.descripcion"/>
                    <TextInput v-model="form.descripcion" id="descripcion" class="mt-1 block w-full" :disabled="!editable" />
                </div>
                <div class="flex flex-col gap-3">
                    <div>
                        <InputLabel value="Es Editable" />
                        <Checkbox v-model="form.editable" :checked="form.editable" :disabled="!editable"/>
                    </div>

                    <div>
                        <InputLabel value="Es Listable" />
                        <Checkbox v-model="form.listable" :checked="form.listable" :disabled="!editable"/>
                    </div>
                </div>
            </div>

            <div v-if="rol?.id !== 1" class="flex flex-col mt-2 gap-3">
                <span class="font-semibold text-[1rem] border-b border-b-gray-400 ">
                    Asignar Permisos
                </span>
                <ul v-for="(permiso, index) in form.permisos" :key="index">
                    <li class="flex gap-5 items-center border-b border-b-gray-400/60 pb-2">
                        <span class="w-36">{{ permiso.nombre }}</span>
                        <div v-for="(accion, index2) in permiso.acciones" :key="index2">
                            <InputLabel :value="accion.nombre" />
                            <Checkbox v-model="accion.checked" :checked="accion.checked" :disabled="!editable"/>
                        </div>
                    </li>
                </ul>
            </div>

            <PrimaryButton v-if="!esVer" type="submit" class="mt-4 self-end" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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

    const props = defineProps(['errors', 'menus', 'rol', 'esVer']);
    const rol = props.rol
    const editable = props.esVer ? false : (rol ? rol.editable : true)

    function getTitulo() {
        if(rol) {
            return props.esVer ? `Ver Rol ${rol.id}` : `Editar Rol ${rol.id}`
        }
        return 'Registrar Rol'
    }

    function getPermisos() {
        const permisos  = props.menus.map(menu => {
            return {
                ...menu,
                acciones: menu.acciones.map(accion => ({
                    ...accion,
                    checked: Boolean(rol?.acciones.find(acc => acc.id === accion.id))
                }))
            }
        })
        return permisos
    }

    const form = useForm({
        id: rol?.id ?? null,
        nombre: rol?.nombre ?? '',
        descripcion: rol?.descripcion ?? '',
        editable: rol?.editable ?? true,
        listable: rol?.listable ?? true,
        permisos: getPermisos()
    });

    function prepareToSend(data) {
        return {
            ...data,
            permisos: data.permisos.flatMap(per => {
                return per.acciones.filter(acc => acc.checked).map(acc => acc.id)
            })
        }
    }

    const submit = () => {
        if(rol?.id) {
            form.transform(prepareToSend).put(route('rol.update', { id: rol.id }))
        } else {
            form.transform(prepareToSend).post(route('rol.store'))
        }
    };

</script>

<style lang="scss" scoped>

</style>
