<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    carnet_identidad: '',
    rol_id: 2
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <!-- <Head title="Register" />

    <AuthenticationCard>
        <div class="flex flex-col items-center gap-4">
            <strong class="self-center">Registrar Cliente</strong>
            <form @submit.prevent="submit" class="w-full">
                <div>
                    <InputLabel for="nombres" value="Nombres" />
                    <TextInput
                        id="nombres"
                        v-model="form.nombres"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Repetir Contraseña" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="mt-4">
                    <InputLabel for="carnet_identidad" value="Carnet Identidad" />
                    <TextInput
                        id="carnet_identidad"
                        v-model="form.carnet_identidad"
                        class="mt-1 block w-full"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Registrar
                    </PrimaryButton>
                </div>
            </form>

        </div>
    </AuthenticationCard> -->
    <div :class="['h-screen overflow-hidden flex items-center justify-center', $page.props.styles.background]">
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
    </div>
</template>
