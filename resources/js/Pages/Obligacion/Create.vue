<template>
    <ManagmentLayout :title="titulo">
        <form @submit.prevent="submit">
            <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <div class="w-full">
                        <InputLabel for="nombre" value="Bien"/>
                        <InputError :message="errors.nombre"/>
                        <TextInput type="text" v-model="form.bien" id="nombre" class="mt-1 block w-full" required :disabled="disabled"/>
                    </div>

                    <div class="w-full">
                        <InputLabel for="descripcion" value="Obligacion"/>
                        <InputError :message="errors.descripcion"/>
                        <TextInput v-model="form.obligacion" id="descripcion" class="mt-1 block w-full" :disabled="disabled"/>
                    </div>
                </div>

               <div class="flex gap-2">
                    <div class="w-full">
                        <InputLabel for="valor_referencial" value="Fecha Vencimiento"/>
                        <InputError :message="errors.valor_referencial"/>
                        <TextInput v-model="form.fecha_vencimiento" id="valor_referencial" class="mt-1 block w-full" :disabled="disabled"/>
                    </div>

                    <div class="w-full">
                        <InputLabel for="valor_referencial" value="Estado"/>
                        <InputError :message="errors.valor_referencial"/>
                        <TextInput v-model="form.estado" id="valor_referencial" class="mt-1 block w-full" :disabled="disabled"/>
                    </div>
                    <div class="w-full">
                        <InputLabel for="valor_referencial" value="Monto"/>
                        <InputError :message="errors.valor_referencial"/>
                        <TextInput v-model="form.precio" id="valor_referencial" class="mt-1 block w-full" :disabled="disabled" type="number"/>
                    </div>
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
import { computed } from 'vue';

    const props = defineProps(['errors', 'item', 'esVer']);
    const item = props.item
    const disabled = props.esVer ? true : false

    const titulo = computed(() => {
         if(item) {
            return props.esVer ? `Ver Obligacion ${item.id}` : `Editar Obligacion ${item.id}`
        }
        return 'Registrar Obligacion'
    })

    const form = useForm({
        id: item?.id ?? null,
        bien: item?.bien?.nombre ?? '',
        obligacion: item?.obligacion_tipo_bien?.nombre ?? '',
        fecha_vencimiento: item?.fecha_vencimiento ?? '',
        precio: item?.obligacion_tipo_bien?.precio ?? 0,
        estado: item?.estado ?? ''
    });

    const submit = () => {
        showLoading()
        if(item?.id) {
            form.put(route('bien.update', { id: item.id }), {
                onFinish() {
                    hideLoading()
                }
            })
        } else {
            form.post(route('bien.store'), {
                onFinish() {
                    hideLoading()
                }
            })
        }
    }

</script>

<style lang="scss" scoped>

</style>
