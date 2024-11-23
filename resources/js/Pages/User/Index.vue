<template>
    <ManagmentLayout title="Lista de Usuarios">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-center">Id</th>
                    <th class="py-3 px-6 text-center">Nombre</th>
                    <th class="py-3 px-6 text-center">Correo</th>
                    <th class="py-3 px-6 text-center">Rol</th>
                    <th class="py-3 px-6 text-center">Carnet de Identidad</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="item in usuarios" :key="item">
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.id }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.name }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.email}}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.rol }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.carnetIdentidad}}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <AuthPermission menu="Gestionar Usuarios" accion="Ver">
                                <VerButton :href="route('user.show', { id: item.id })" />
                            </AuthPermission>

                            <AuthPermission menu="Gestionar Usuarios" accion="Editar">
                                <EditarButton :href="route('user.edit', { id: item.id })" />
                            </AuthPermission>

                            <AuthPermission menu="Gestionar Usuarios" accion="Eliminar">
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
                <p>¿Estás seguro de que quieres eliminar el Menú con id <strong> {{ selectedItem }}</strong>?</p>
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
    const props = defineProps(['items'])

    const usuarios = props.items.map(user => {
        return {
            ...user,
            rol: user.rol.nombre,
            carnetIdentidad: user.cliente?.carnet_identidad
        }
    })

    const deleteItem = () => {
        if (selectedItem.value) {
            router.delete(route('menu.destroy', { id: selectedItem.value }))
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
