<template>
    <ManagmentLayout title="Lista de Menús">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-center">Id</th>
                    <th class="py-3 px-6 text-center">Nombre</th>
                    <th class="py-3 px-6 text-center">Descripcion</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="item in menus" :key="item">
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.id }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.nombre }}
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        {{ item.descripcion}}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <AuthPermission menu="Gestionar Menu" accion="Ver">
                                <VerButton />
                            </AuthPermission>

                            <AuthPermission menu="Gestionar Menu" accion="Editar">
                                <EditarButton />
                            </AuthPermission>

                            <AuthPermission menu="Gestionar Menu" accion="Eliminar">
                                <EliminarButton />
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
                <p>¿Estás seguro de que quieres eliminar al usuario <strong> {{ selectedUser?.name }} ({{  selectedUser?.email }}) </strong>?</p>
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deleteUser" class="bg-red-500 hover:bg-red-800">Eliminar</PrimaryButton>
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
import Paginator from '@/Components/Paginator.vue';
import AuthPermission from '@/Components/AuthPermission.vue';
import VerButton from '@/Components/VerButton.vue';
import EditarButton from '@/Components/EditarButton.vue';
import EliminarButton from '@/Components/EliminarButton.vue';
import NuevoButton from '@/Components/NuevoButton.vue';
const props = defineProps(['menus'])
console.log(props.menus);
// Función para manejar la eliminación del usuario
const deleteUser = (user) => {
    if (selectedUser.value) {
        router.delete(route('user.destroy', { user: selectedUser.value.id }));
        showModal.value = false;
    }
};
// Estado para manejar la visibilidad del modal y el usuario seleccionado
const showModal = ref(false);
const selectedUser = ref(null);
// Función para abrir el modal de confirmación
const confirmDeleteUser = (user) => {
    selectedUser.value = user;
    showModal.value = true;
};

</script>

<style lang="scss" scoped>

</style>
