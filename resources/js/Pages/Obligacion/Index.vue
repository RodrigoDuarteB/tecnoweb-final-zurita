<template>
    <ManagmentLayout title="Lista de Obligaciones">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-center">Id</th>
                    <th class="py-3 px-6 text-center" v-if="es_admin">Cliente</th>
                    <th class="py-3 px-6 text-center">Bien</th>
                    <th class="py-3 px-6 text-center">Obligacion</th>
                    <th class="py-3 px-6 text-center">Fecha Vencimiento</th>
                    <th class="py-3 px-6 text-center">Estado</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="item in items" :key="item">
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.id }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap" v-if="es_admin">
                        {{ item.bien.cliente.usuario.name }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.bien.nombre }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.obligacion_tipo_bien.nombre}}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.fecha_vencimiento }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.estado }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <AuthPermission menu="Gestionar Obligacion" accion="Ver">
                                <VerButton :href="route('obligacion.show', { id: item.id })" />
                            </AuthPermission>

                            <AuthPermission menu="Gestionar Obligacion" accion="Editar">
                                <EditarButton :href="route('obligacion.edit', { id: item.id })" />
                            </AuthPermission>

                            <AuthPermission menu="Gestionar Obligacion" accion="Eliminar">
                                <EliminarButton @click="confirmDeleteItem(item.id)"/>
                            </AuthPermission>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <DialogModal :show="showModal" @close="showModal = false">
            <template v-slot:title>
                <h1>Confirmar Eliminación</h1>
            </template>
            <template v-slot:content>
                <p>¿Estás seguro de que quieres eliminar la obligación con id <strong> {{ selectedItem }}</strong>?</p>
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deleteItem" class="bg-red-500 hover:bg-red-800">Eliminar</PrimaryButton>
                <button @click="showModal = false" class="ml-4">Cancelar</button>
            </template>
        </DialogModal>
    </ManagmentLayout>
</template>

<script setup>
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue';
import AuthPermission from '@/Components/AuthPermission.vue';
import VerButton from '@/Components/VerButton.vue';
import EditarButton from '@/Components/EditarButton.vue';
import EliminarButton from '@/Components/EliminarButton.vue';
import { hideLoading, showLoading } from '@/state';
    const props = defineProps(['items', 'es_admin'])

    const deleteItem = () => {
        if (selectedItem.value) {
            showLoading()
            router.delete(route('obligacion.destroy', { id: selectedItem.value }), {
                onFinish: () => hideLoading()
            })
            showModal.value = false;
        }
    };

    const showModal = ref(false);
    const selectedItem = ref(null);

    const confirmDeleteItem = (id) => {
        selectedItem.value = id;
        showModal.value = true;
    };
</script>

<style lang="scss" scoped>

</style>
