<template>
    <ManagmentLayout :title="getTitulo()">
        <form @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full" v-if="esVer">
                    <InputLabel value="Fecha Hora Pago"/>
                    <TextInput v-model="form.fecha_hora" class="mt-1 block w-full" :disabled="true" />
                </div>

                <div class="w-full" v-if="esVer">
                    <InputLabel value="Fecha Hora Confirmacion"/>
                    <TextInput v-model="form.fecha_hora_confirmacion" class="mt-1 block w-full" :disabled="true" />
                </div>

                <div class="w-full" v-if="esVer || esConfirmar">
                    <InputLabel value="Estado"/>
                    <TextInput v-model="form.estado" class="mt-1 block w-full" :disabled="true"/>
                </div>
            </div>

            <ObligacionesPendientes
                :items="obligacionesPendientes"
                @onAdd="addObligation"
            />

            <div class="flex flex-col mt-2 gap-3">
                <InputError :message="errors.servicios"/>
                <div class="my-2" v-if="editable">
                    <AutcompletarServicios @select="handleAddServicio"/>
                </div>
                <span class="font-semibold text-[1rem] border-b border-b-gray-400">
                    Detalle del Pago
                </span>

                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-center">Id</th>
                            <th class="py-3 px-6 text-center">Tipo</th>
                            <th class="py-3 px-6 text-center">Nombre</th>
                            <th class="py-3 px-6 text-center">Cantidad</th>
                            <th class="py-3 px-6 text-center">Costo p/u</th>
                            <th class="py-3 px-6 text-center">Descuento p/u</th>
                            <th class="py-3 px-6 text-center">Total Descuento</th>
                            <th class="py-3 px-6 text-center">Subtotal</th>
                            <th class="py-3 px-6 text-center" v-if="editable">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="(item, index) in form.servicios" :key="item">
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.id }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.esObligacion ? 'Obligación' : 'Servicio' }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.nombre }}
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap">
                                <div v-if="editable" class="flex gap-2 items-center justify-center">
                                    <button @click="handleChangeCantidad({ index, type: '-' })" type="button" class="px-2 py-1 bg-blue-400 rounded-md font-semibold text-[1rem]" v-if="!item.esObligacion">
                                        -
                                    </button>
                                    <span>{{ item.cantidad }}</span>
                                    <button @click="handleChangeCantidad({ index, type: '+' })" type="button" class="px-2 py-1 bg-blue-400 rounded-md font-semibold text-[1rem]" v-if="!item.esObligacion">
                                        +
                                    </button>
                                </div>
                                <div v-else class="text-center">
                                    {{ item.cantidad }}
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ numberFormat.format(item.precio) }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.monto_descuento ? numberFormat.format(item.monto_descuento) : '-' }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ item.total_descuento ? numberFormat.format(item.total_descuento) : '-' }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ numberFormat.format(item.subtotal) }}
                            </td>
                            <td class="py-3 px-6 text-center" v-if="editable">
                                <div class="flex item-center justify-center">
                                    <EliminarButton
                                        @click="() => handleDeleteServicio(index)"  svg-class="size-6"
                                        v-if="!esVer"
                                    />
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="py-3 px-6 text-center whitespace-nowrap font-semibold">
                                Total {{ numberFormat.format(getSubtotal()) }}
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="esConfirmar && pago?.estado == 'Pendiente'" class="flex flex-col items-center">
                <spam class="text-[1.2rem]">Para confirmar debes escanear el qr con el banco de tu preferencia y confirmar una vez pagado</spam>
                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d7/Commons_QR_code.png" width="300"/>
                <PrimaryButton type="submit" class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirmar
                </PrimaryButton>
            </div>

            <PrimaryButton v-if="editable" type="submit" class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
import AutcompletarServicios from '@/Components/AutcompletarServicios.vue';
import { ourParseFloat } from '@/utils';
import ObligacionesPendientes from './ObligacionesPendientes.vue';

    const props = defineProps(['errors', 'pago', 'servicios', 'esVer', 'esConfirmar', 'obligacionesPendientes']);
    const pago = props.pago
    const numberFormat = Intl.NumberFormat('es-BO', {maximumFractionDigits: 2})
    const editable = !props.esVer && !props.esConfirmar
    function getTitulo() {
        if(pago) {
            return props.esVer ? `Ver Pago ${pago.id}` : `Confirmar Pago ${pago.id}`
        }
        return 'Registrar Pago'
    }

    function getServicios() {
        if(pago) {
            return pago.servicios.map(serv => {
                const pivote = serv.pivot
                return {
                    ...serv,
                    cantidad: pivote.cantidad,
                    monto_descuento: pivote.monto_descuento,
                    total_descuento: pivote.total_descuento,
                    subtotal: pivote.subtotal
                }
            })
        }
        return []
    }

    const form = useForm({
        id: pago?.id ?? null,
        fecha_hora: pago?.fecha_hora ?? '',
        fecha_hora_confirmacion: pago?.fecha_hora_confirmacion ?? '',
        estado: pago?.estado ?? 'Pendiente',
        servicios: getServicios()
    });

    function prepareToSend(data) {
        return {
            ...data,
            servicios: data.servicios.map(serv => ({
                servicio_id: serv.id,
                monto_servicio: serv.precio,
                monto_descuento: serv.monto_descuento,
                porcentaje_descuento: serv.descuento?.porcentaje,
                subtotal: serv.subtotal,
                cantidad: serv.cantidad,
                total_descuento: serv.total_descuento
            }))
        }
    }

    const submit = () => {
        if(!form.servicios.length) return alert('Debe agregar almenos un servicio!')
        showLoading()
        if(pago?.id) {
            form.put(route('pago.update', { id: pago.id }), {
                onFinish() {
                    hideLoading()
                }
            })
        } else {
            form.transform(prepareToSend).post(route('pago.store'), {
                onFinish() {
                    hideLoading()
                }
            })
        }
    }

    function handleAddServicio(item) {
        if(form.servicios.find(serv => serv.id == item.id)) return alert('Servicio ya añadido')
        form.servicios.push({
            ...item,
            cantidad: 1,
            nombre: item.nombre.split('/')[0].trim()
        })
    }

    function handleDeleteServicio(index) {
        form.servicios.splice(index, 1)
    }

    function getSubtotal() {
        return form.servicios.reduce((acc, item) => acc + ourParseFloat(item.subtotal), 0)
    }

    function handleChangeCantidad({ index, type }) {
        const item = form.servicios[index]
        if(type == '-' && item.cantidad > 1) {
            item.cantidad--
        } else if(type == '+') {
            item.cantidad++
        }
        setearTotalDescuentoYSubtotal(item)
    }

    function setearTotalDescuentoYSubtotal(item) {
        if(item.descuento && item.monto_descuento) {
            item.total_descuento = item.monto_descuento * item.cantidad
            item.subtotal = (item.precio - item.monto_descuento) * item.cantidad
        } else {
            item.subtotal = item.precio * item.cantidad
        }
    }

    function addObligation(id) {
        const obligacion = props.obligacionesPendientes.find(ob => ob.id == id)
        form.servicios.push({
            ...obligacion,
            esObligacion: true
        })
    }

</script>

<style lang="scss" scoped>

</style>
