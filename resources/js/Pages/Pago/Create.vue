<template>
    <ManagmentLayout :title="getTitulo()">
        <form @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full" v-if="esVer">
                    <InputLabel value="Fecha Hora Pago"/>
                    <TextInput v-model="form.fecha_hora" class="mt-1 block w-full" :disabled="true" type="date"/>
                </div>

                <div class="w-full" v-if="esVer">
                    <InputLabel value="Fecha Hora Confirmacion"/>
                    <TextInput v-model="form.fecha_hora_confirmacion" class="mt-1 block w-full" :disabled="true" type="date"/>
                </div>

                <div class="w-full">
                    <InputLabel value="Estado"/>
                    <TextInput v-model="form.estado" class="mt-1 block w-full" :disabled="true"/>
                </div>
            </div>

            <div class="flex flex-col mt-2 gap-3">
                <InputError :message="errors.servicios"/>
                <div class="my-2" v-if="!esVer">
                    <InputLabel value="Añadir Servicios"/>
                    <SelectAdd :items="getServiciosItems()" @selected="handleAddServicio" button-label="Añadir Servicios al Pago" class="w-full"/>
                    <button @click="handleBuscar">Buscar</button>
                </div>
                <span class="font-semibold text-[1rem] border-b border-b-gray-400">
                    Servicios del Pago
                </span>

                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-center">Id</th>
                            <th class="py-3 px-6 text-center">Nombre</th>
                            <th class="py-3 px-6 text-center">Costo</th>
                            <th class="py-3 px-6 text-center">Descuento</th>
                            <th class="py-3 px-6 text-center">Subtotal</th>
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
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.precio }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.descuento }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.subtotal }}
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

    const props = defineProps(['errors', 'pago', 'servicios', 'esVer']);
    const pago = props.pago
    const disabled = props.esVer ? true : false

    function getTitulo() {
        if(pago) {
            return props.esVer ? `Ver Pago ${pago.id}` : `Editar Pago ${pago.id}`
        }
        return 'Registrar Pago'
    }

    function getServiciosItems() {
        return props.servicios?.map(servicio => ({
            label: servicio.nombre,
            value: servicio.id
        }))
    }

    const form = useForm({
        id: pago?.id ?? null,
        fecha_hora: pago?.fecha_hora ?? '',
        fecha_hora_confirmacion: pago?.fecha_hora ?? '',
        estado: pago?.estado ?? 'Pendiente',
        servicios: pago?.servicios ?? []
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

    const formBuscar = useForm({
        termino: ''
    })

    function handleBuscar() {
        formBuscar.post(route('pago.buscar'))
    }

</script>

<style lang="scss" scoped>

</style>
