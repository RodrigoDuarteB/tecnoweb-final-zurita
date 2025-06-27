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

            <div class="mt-3">
                <div class="flex gap-2 items-center">
                    <span class="font-semibold text-[1.3rem]">Obligaciones</span>
                    <PrimaryButton type="button" class="mt-4 ml-2 w-fit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || disabled" @click="addObligacion">Añadir</PrimaryButton>
                </div>
                <ObligacionTipoBienRow
                    v-for="(obligacion, i) in form.obligaciones.filter(el => el.estado == 'Activo')"
                    :key="obligacion.id"
                    :item="obligacion"
                    :is-last="i == form.obligaciones.length - 1"
                    @delete="handleDeleteObligacion(obligacion.id, i)"
                    :disabled="disabled"
                />
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
import ObligacionTipoBienRow from '@/Components/ObligacionTipoBienRow.vue';

    const props = defineProps(['errors', 'item', 'esVer']);
    const item = props.item
    const disabled = props.esVer ? true : false

    function getTitulo() {
        if(item) {
            return props.esVer ? `Ver Tipo Bien ${item.id}` : `Editar Tipo Bien ${item.id}`
        }
        return 'Registrar Tipo Bien'
    }

    const form = useForm({
        id: item?.id ?? null,
        nombre: item?.nombre ?? '',
        descripcion: item?.descripcion ?? '',
        obligaciones: item?.obligaciones ?? [
            {
                id: null,
                nombre: '',
                tipo: '',
                frecuencia: '',
                precio: '',
                estado: 'Activo'
            }
        ]
    });

    function addObligacion() {
        form.obligaciones.push({
            id: null,
            nombre: '',
            tipo: '',
            frecuencia: '',
            precio: '',
            estado: 'Activo'
        })
    }

    function handleDeleteObligacion(id, index) {
        if(id) {
            form.obligaciones.find(el => el.id == id).estado = 'Inactivo'
        } else {
            form.obligaciones.splice(index, 1)
        }
    }

    const submit = () => {
        showLoading()
        if(item?.id) {
            form.put(route('tipoBien.update', { id: item.id }), {
                onFinish() {
                    hideLoading()
                }
            })
        } else {
            form.post(route('tipoBien.store'), {
                onFinish() {
                    hideLoading()
                }
            })
        }
    }

</script>

<style lang="scss" scoped>

</style>
