<template>
    <ManagmentLayout title="Registrar Rol">
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
                <div class="flex flex-col gap-3">
                    <div>
                        <InputLabel value="Es Editable" />
                        <Checkbox v-model="form.editable" :checked="form.editable" />
                    </div>

                    <div>
                        <InputLabel value="Es Listable" />
                        <Checkbox v-model="form.listable" :checked="form.listable" />
                    </div>
                </div>
            </div>

            <div class="flex flex-col mt-2 gap-3">
                <span class="font-semibold text-[1rem] border-b border-b-gray-400 ">
                    Asignar Permisos
                </span>
                <ul v-for="(permiso, index) in form.permisos" :key="index">
                    <li class="flex gap-5 items-center border-b border-b-gray-400/60 pb-2">
                        <span class="w-36">{{ permiso.nombre }}</span>
                        <div v-for="(accion, index2) in permiso.acciones" :key="index2">
                            <InputLabel :value="accion.nombre" />
                            <Checkbox v-model="accion.checked" :checked="accion.checked" />
                        </div>
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
import { groupBy } from 'lodash'

    const props = defineProps(['errors', 'rol']);
    const rol = props.rol
    console.log(rol);

    function getPermisos() {
        const grouped = groupBy(rol.permisos, 'accion.menu_id')
        return Object.values(grouped).map((permisos) => {
            const nombre = permisos[0].accion.menu.nombre
            return {
                nombre,
                acciones: permisos.map(per => {
                    return {
                        ...per.accion,
                        checked: true
                    }
                })
            }
        })
    }

    console.log(getPermisos());

    const form = useForm({
        id: rol.id,
        nombre: rol.nombre,
        descripcion: rol.descripcion,
        editable: rol.editable,
        listable: rol.listable,
        permisos: getPermisos()
    });

    const submit = () => {
        form.transform(data => {
            return {
                ...data,
                permisos: data.permisos.flatMap(per => {
                    return per.acciones.filter(acc => acc.checked).map(acc => ({ accion_id: acc.id}))
                })
            }
        }).post(route('rol.store'))
    };

</script>

<style lang="scss" scoped>

</style>
