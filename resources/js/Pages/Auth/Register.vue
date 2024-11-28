<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Loading from '@/Components/Loading.vue';
import { ref } from 'vue';
import { getTimeStyles } from '@/utils';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    carnet_identidad: '',
    rol_id: 2 //cliente
});

const loading = ref(false)

const submit = () => {
    loading.value = true;
    form.post(route('register'), {
        onFinish: () => {
            loading.value = false
            form.reset('password', 'password_confirmation')
        }
    });
};
const styles = getTimeStyles()
</script>

<template>
    <div :class="['h-screen overflow-hidden flex items-center justify-center', styles.background]">
        <div class="w-[700px] min-h-screen flex items-center justify-center text-center md:px-16 px-0 z-0 bg-gray-800">
            <div class="w-full py-6 z-20">
                <p class="text-gray-100 font-semibold text-2xl mb-10">
                    Registrarse
                </p>

                <form @submit.prevent="submit" class="sm:w-2/3 w-full px-4 lg:px-0 mx-auto">
                    <div class="mb-3">
                        <InputLabel for="name" value="Nombres" class="text-white"/>
                        <TextInput
                            id="name"
                            v-model="form.name"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" class="text-white"/>
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4 flex gap-3">
                        <div>
                            <InputLabel for="password" value="Contraseña" class="text-white"/>
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div>
                            <InputLabel for="password_confirmation" value="Repetir Contraseña" class="text-white"/>
                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="carnet_identidad" value="Carnet de Identidad" class="text-white"/>
                        <TextInput
                            id="carnet_identidad"
                            v-model="form.carnet_identidad"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.carnet_identidad" />
                    </div>

                    <PrimaryButton class="mt-4 bg-blue-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Registrarse
                    </PrimaryButton>
                </form>
            </div>
        </div>
        <Loading :is-visible="loading"/>
    </div>
</template>
