<template>
    <ManagmentLayout :title="getTitulo()">
        <form @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-4">
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

                <div class="w-full">
                    <InputLabel for="porcentaje" value="Porcentaje"/>
                    <InputError :message="errors.porcentaje"/>
                    <TextInput v-model="form.porcentaje" id="porcentaje" class="mt-1 block w-full" :disabled="disabled" required type="number"/>
                </div>

                <div class="w-full">
                    <InputLabel for="fecha_inicio" value="Fecha Inicio"/>
                    <InputError :message="errors.fecha_inicio"/>
                    <TextInput v-model="form.fecha_inicio" id="fecha_inicio" class="mt-1 block w-full" :disabled="disabled" type="date" required/>
                </div>

                <div class="w-full">
                    <InputLabel for="fecha_fin" value="Fecha Fin"/>
                    <InputError :message="errors.fecha_fin"/>
                    <TextInput v-model="form.fecha_fin" id="fecha_fin" class="mt-1 block w-full" :disabled="disabled" type="date" required/>
                </div>
            </div>

            <div class="flex flex-col mt-2 gap-3">
                <InputError :message="errors.servicios"/>
                <div class="my-2" v-if="!esVer">
                    <InputLabel value="Añadir Servicios"/>
                    <SelectAdd :items="getServiciosItems()" @selected="handleAddServicio" button-label="Añadir Servicios" class="w-full"/>
                </div>
                <span class="font-semibold text-[1rem] border-b border-b-gray-400">
                    Servicios
                </span>

                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-center">Id</th>
                            <th class="py-3 px-6 text-center">Nombre</th>
                            <th class="py-3 px-6 text-center" v-if="!esVer">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="item in form.servicios" :key="item">
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.id }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.nombre }}
                            </td>
                            <td class="py-3 px-6 text-center" v-if="!esVer">
                                <div class="flex item-center justify-center">
                                    <EliminarButton
                                        @click="() => handleDeleteServicio(index)"  svg-class="size-6"
                                        v-if="!esVer"
                                    />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
import EliminarButton from '@/Components/EliminarButton.vue';
import { hideLoading, showLoading } from '@/state';
import SelectAdd from '@/Components/SelectAdd.vue';

    const props = defineProps(['errors', 'descuento', 'servicios', 'esVer']);
    const descuento = props.descuento
    const disabled = props.esVer ? true : false

    function getTitulo() {
        if(descuento) {
            return props.esVer ? `Ver Descuento ${descuento.id}` : `Editar Descuento ${descuento.id}`
        }
        return 'Registrar Descuento'
    }

    function getServiciosItems() {
        return props.servicios?.map(servicio => ({
            label: servicio.nombre,
            value: servicio.id
        }))
    }

    const form = useForm({
        id: descuento?.id ?? null,
        nombre: descuento?.nombre ?? '',
        descripcion: descuento?.descripcion ?? '',
        porcentaje: descuento?.porcentaje ?? 0,
        fecha_inicio: descuento?.fecha_inicio_for_input ?? null,
        fecha_fin: descuento?.fecha_fin_for_input ?? null,
        servicios: descuento?.servicios ?? []
    });

    function prepareToSend(data) {
        return {
            ...data,
            servicios: data.servicios.map(serv => serv.id)
        }
    }

    const submit = () => {
        showLoading()
        if(descuento?.id) {
            form.transform(prepareToSend).put(route('descuento.update', { id: descuento.id }), {
                onFinish() {
                    hideLoading()
                }
            })
        } else {
            form.transform(prepareToSend).post(route('descuento.store'), {
                onFinish() {
                    hideLoading()
                }
            })
        }
    }

    function handleAddServicio(id) {
        if(id) {
            if(form.servicios.find(serv => serv.id == id)) {
                return alert('Servicio ya Añadido!')
            }
            const servicio = props.servicios.find(serv => serv.id == id)
            if(servicio) {
                form.servicios.push(servicio)
            }
        }
    }

    function handleDeleteServicio(index) {
        form.servicios.splice(index, 1)
    }

</script>

<style lang="scss" scoped>

</style>
