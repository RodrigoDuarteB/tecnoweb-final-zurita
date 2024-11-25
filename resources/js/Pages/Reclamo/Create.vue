<template>
    <ManagmentLayout :title="getTitulo()">
        <form @submit.prevent="submit">
            <div class="flex gap-2">
                <div class="w-full">
                    <InputLabel for="reclamo" value="Reclamo"/>
                    <InputError :message="errors.reclamo"/>
                    <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" v-model="form.reclamo" :disabled="disabled"></textarea>
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
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { hideLoading, showLoading } from '@/state';

    const props = defineProps(['errors', 'reclamo', 'esVer']);
    const reclamo = props.reclamo
    const disabled = props.esVer ? true : false

    function getTitulo() {
        if(reclamo) {
            return props.esVer ? `Ver Reclamo ${reclamo.id}` : `Editar Reclamo ${reclamo.id}`
        }
        return 'Registrar Reclamo'
    }

    const form = useForm({
        id: reclamo?.id ?? null,
        reclamo: reclamo?.reclamo ?? ''
    });

    const submit = () => {
        showLoading()
        if(reclamo?.id) {
            form.put(route('reclamo.update', { id: menu.id }), {
                onFinish() {
                    hideLoading()
                }
            })
        } else {
            form.post(route('reclamo.store'), {
                onFinish() {
                    hideLoading()
                }
            })
        }
    }

</script>

<style lang="scss" scoped>

</style>
