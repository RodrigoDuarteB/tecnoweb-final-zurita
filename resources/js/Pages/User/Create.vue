<template>
    <ManagmentLayout :title="getTitulo()">
        <form @submit.prevent="submit">
            <div class="flex gap-2">
                <div class="w-full">
                    <InputLabel for="nombre" value="Nombre"/>
                    <InputError :message="errors.name"/>
                    <TextInput type="text" v-model="form.name" id="nombre" class="mt-1 block w-full" required :disabled="disabled"/>
                </div>

                <div class="w-full">
                    <InputLabel for="correo" value="Correo"/>
                    <InputError :message="errors.email"/>
                    <TextInput v-model="form.email" id="correo" class="mt-1 block w-full" :disabled="disabled" required />
                </div>

                <div class="w-full">
                    <InputLabel for="rol" value="Rol"/>
                    <InputError :message="errors.rol_id"/>
                    <Select v-model="form.rol_id" id="rol" class="mt-1 block w-full" :disabled="disabled" :items="getSelectItems()" required/>
                </div>
            </div>

            <p v-if="!esVer" class="text-red-400">
                **Se generará una contraseña random que será enviado al correo de registro
            </p>

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
import Select from '@/Components/Select.vue';

    const props = defineProps(['errors', 'user', 'esVer', 'roles']);
    const usuario = props.user
    const disabled = props.esVer ? true : false

    function getTitulo() {
        if(usuario) {
            return props.esVer ? `Ver Usuario ${usuario.id}` : `Editar Usuario ${usuario.id}`
        }
        return 'Registrar Usuario'
    }

    function getSelectItems() {
        return props.roles.map(rol => ({ label: rol.nombre, value: rol.id }))
    }

    const form = useForm({
        id: usuario?.id ?? null,
        name: usuario?.name ?? '',
        email: usuario?.email ?? '',
        rol_id: usuario?.rol_id ?? null
    });

    const submit = () => {
        if(usuario?.id) {
            form.put(route('user.update', { id: usuario.id }))
        } else {
            form.post(route('user.store'))
        }
    }

</script>

<style lang="scss" scoped>

</style>
