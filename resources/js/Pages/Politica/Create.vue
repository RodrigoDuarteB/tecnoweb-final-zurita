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

    const props = defineProps(['errors', 'politica', 'esVer']);
    const politica = props.politica
    const disabled = props.esVer ? true : false

    function getTitulo() {
        if(politica) {
            return props.esVer ? `Ver Política ${politica.id}` : `Editar Política ${politica.id}`
        }
        return 'Registrar Política'
    }

    const form = useForm({
        id: politica?.id ?? null,
        nombre: politica?.nombre ?? '',
        descripcion: politica?.descripcion ?? ''
    });

    const submit = () => {
        showLoading()
        if(politica?.id) {
            form.put(route('politica.update', { id: politica.id }), {
                onFinish() {
                    hideLoading()
                }
            })
        } else {
            form.post(route('politica.store'), {
                onFinish() {
                    hideLoading()
                }
            })
        }
    }

</script>

<style lang="scss" scoped>

</style>
