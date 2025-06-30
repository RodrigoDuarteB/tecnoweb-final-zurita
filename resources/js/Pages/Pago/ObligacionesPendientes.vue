<template>
    <div class="flex flex-col gap-4">
        <span class="font-semibold text-[1rem] border-b border-b-gray-400">
            Obligaciones Pendientes
        </span>

        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-center">Id</th>
                    <th class="py-3 px-6 text-center">Nombre</th>
                    <th class="py-3 px-6 text-center">Cantidad</th>
                    <th class="py-3 px-6 text-center">Costo p/u</th>
                    <th class="py-3 px-6 text-center">Descuento p/u</th>
                    <th class="py-3 px-6 text-center">Total Descuento</th>
                    <th class="py-3 px-6 text-center">Subtotal</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="(item, index) in items" :key="item.id">
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.id }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.nombre }}
                    </td>
                    <td class="py-3 px-6 whitespace-nowrap">
                        <div v-if="editable" class="flex gap-2 items-center justify-center">
                            <button disabled type="button" class="px-2 py-1 bg-blue-400 rounded-md font-semibold text-[1rem]">
                                -
                            </button>
                            <span>{{ item.cantidad }}</span>
                            <button disabled type="button" class="px-2 py-1 bg-blue-400 rounded-md font-semibold text-[1rem]">
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
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <PrimaryButton
                                @click="emits('onAdd', item.id)"
                                type="button"
                                :disabled="esAñadido(item.id)"
                            >
                                {{ esAñadido(item.id) ? 'Añadido' : 'Añadir' }}
                            </PrimaryButton>
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
                        Total {{ numberFormat.format(totalSubtotal) }}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ourParseFloat } from '@/utils';
import { computed } from 'vue'

    const props = defineProps(['items', 'servicios'])
    const emits = defineEmits(['onDelete', 'onAdd'])
    const numberFormat = Intl.NumberFormat('es-BO', {maximumFractionDigits: 2})
    const totalSubtotal = computed(() =>
        props.items.reduce((sum, item) => sum + ourParseFloat(item.subtotal), 0)
    );

    const esAñadido = computed(() => {
        return (id) => {
            return !!props.servicios?.find(el => el.id == id)
        }
    })
</script>

<style lang="scss" scoped>

</style>
