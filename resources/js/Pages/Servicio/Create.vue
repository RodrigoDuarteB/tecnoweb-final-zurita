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
                    <InputLabel for="precio" value="Costo"/>
                    <InputError :message="errors.precio"/>
                    <TextInput v-model="form.precio" id="precio" class="mt-1 block w-full" :disabled="disabled" type="number"/>
                </div>
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
import { hideLoading, showLoading } from '@/state';

    const props = defineProps(['errors', 'servicio', 'esVer']);
    const servicio = props.servicio
    const disabled = props.esVer ? true : false

    function getTitulo() {
        if(servicio) {
            return props.esVer ? `Ver Servicio ${servicio.id}` : `Editar Servicio ${servicio.id}`
        }
        return 'Registrar Servicio'
    }

    const form = useForm({
        id: servicio?.id ?? null,
        nombre: servicio?.nombre ?? '',
        precio: servicio?.precio ?? 0
    });

    const submit = () => {
        showLoading()
        if(servicio?.id) {
            form.put(route('servicio.update', { id: servicio.id }), {
                onFinish() {
                    hideLoading()
                }
            })
        } else {
            form.post(route('servicio.store'), {
                onFinish() {
                    hideLoading()
                }
            })
        }
    }
</script>

<style lang="scss" scoped>

</style>
