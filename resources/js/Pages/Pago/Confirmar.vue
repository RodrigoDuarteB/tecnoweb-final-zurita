<template>
    <ManagmentLayout :title="'Confirmar Pago ' + pago.id">
        <form @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full">
                    <InputLabel value="Fecha Hora Pago"/>
                    <TextInput v-model="form.fecha_hora" class="mt-1 block w-full" :disabled="true" />
                </div>

                <div class="w-full">
                    <InputLabel value="Estado"/>
                    <TextInput v-model="form.estado" class="mt-1 block w-full" :disabled="true"/>
                </div>
            </div>

            <div class="flex flex-col mt-2 gap-3">
                <span class="font-semibold text-[1rem] border-b border-b-gray-400">
                    Servicios del Pago
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
                                <div class="text-center">
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
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col items-center">
                <spam class="text-[1.2rem]">Para confirmar debes escanear el qr con el banco de tu preferencia y confirmar una vez pagado</spam>
                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d7/Commons_QR_code.png" width="300"/>
                <PrimaryButton type="submit" class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirmar
                </PrimaryButton>
            </div>
        </form>
    </ManagmentLayout>
</template>

<script setup>
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { hideLoading, showLoading } from '@/state';
import { ourParseFloat } from '@/utils';

    const props = defineProps(['errors', 'pago']);
    const pago = props.pago
    const numberFormat = Intl.NumberFormat('es-BO', {maximumFractionDigits: 2})

    function getServicios() {
        let servicios = []
        servicios = pago.servicios.map(serv => {
            const pivote = serv.pivot
            return {
                ...serv,
                cantidad: pivote.cantidad,
                monto_descuento: pivote.monto_descuento,
                total_descuento: pivote.total_descuento,
                subtotal: pivote.subtotal
            }
        })
        servicios.push(...getObligaciones())
        return servicios
    }

    function getObligaciones() {
        if(pago?.obligaciones) {
            return pago.obligaciones.map(ob => {
                const pivote = ob.pivot
                const bien = ob.bien
                const tipo_ob = ob.obligacion_tipo_bien
                return {
                    ...ob,
                    nombre: `${tipo_ob?.nombre} (${bien?.nombre})`,
                    precio: tipo_ob?.precio,
                    esObligacion: true,
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
        ...pago,
        servicios: getServicios()
    })

    const submit = () => {
        showLoading()
        form.put(route('pago.update', { id: pago.id }), {
            onFinish() {
                hideLoading()
            }
        })
    }

    function getSubtotal() {
        return form.servicios.reduce((acc, item) => acc + ourParseFloat(item.subtotal), 0)
    }

</script>

<style lang="scss" scoped>

</style>
