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

    const props = defineProps(['errors', 'menus']);
    console.log(props.menus);

    const form = useForm({
        nombre: '',
        descripcion: '',
        permisos: props.menus.map(menu => {
            return {
                ...menu,
                acciones: menu.acciones.map(accion => ({...accion, checked: false }))
            }
        })
    });

    // Función para manejar el envío del formulario
    const submit = () => {
        //console.log(form);
        /* console.log(form.transform(data => {
            return {
                ...data,
                permisos: data.permisos.filter(per => per.acciones.some(acc => acc.checked)).map(per => ({
                    ...per,
                    acciones: per.acciones.filter(acc => acc.checked)
                }))
            }
        })) */
        //form.post(route('rol.store'));
    };

</script>

<style lang="scss" scoped>

</style>
