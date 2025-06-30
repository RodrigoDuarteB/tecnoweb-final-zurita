<template>
    <ManagmentLayout :title="titulo">
        <form @submit.prevent="submit">
            <div class="flex flex-col gap-2">
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

               <div class="flex gap-2">
                    <div class="w-full">
                        <InputLabel for="valor_referencial" value="Valor Referencial"/>
                        <InputError :message="errors.valor_referencial"/>
                        <TextInput v-model="form.valor_referencial" id="valor_referencial" class="mt-1 block w-full" :disabled="disabled" type="number"/>
                    </div>

                    <div class="flex gap-2 items-center w-full">
                        <div class="w-full">
                            <InputLabel for="tipo_bien" value="Tipo de Bien"/>
                            <InputError :message="errors.tipo_bien_id"/>
                            <Select v-model="form.tipo_bien_id" id="tipo_bien" class="mt-1 block w-full" :disabled="disabled" :items="items" required/>
                        </div>
                        <VerButton v-if="form.tipo_bien_id" :href="route('tipoBien.show', { id: form.tipo_bien_id })" />
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
import Select from '@/Components/Select.vue';
import VerButton from '@/Components/VerButton.vue';

    const props = defineProps(['errors', 'item', 'esVer', 'tiposBien']);
    const item = props.item
    const disabled = props.esVer ? true : false

    const titulo = computed(() => {
         if(item) {
            return props.esVer ? `Ver Bien ${item.id}` : `Editar Bien ${item.id}`
        }
        return 'Registrar Bien'
    })

    const items = computed(() => {
        return props.tiposBien?.map((tb) => {
            return {
                label: tb.nombre,
                value: tb.id
            }
        })
    })

    const form = useForm({
        id: item?.id ?? null,
        nombre: item?.nombre ?? '',
        descripcion: item?.descripcion ?? '',
        valor_referencial: item?.valor_referencial ?? 0,
        tipo_bien_id: item?.tipo_bien_id
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
