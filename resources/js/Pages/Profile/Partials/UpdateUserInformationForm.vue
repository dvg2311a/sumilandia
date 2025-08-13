<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ImageInput from '@/Components/ImageInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const profile = user.profile || {};



const userForm = useForm({
    first_name: user.first_name || '',
    last_name: user.last_name || '',
    email: user.email || '',
});

const submitUser = () => {
    userForm.first_name = String(userForm.first_name || '');
    userForm.last_name = String(userForm.last_name || '');
    userForm.email = String(userForm.email || '');
    userForm.patch(route('profile.user.update'));
};
</script>

<template>
    <section>
        <header class="header-profile">
            <h2>
                Información del usuario
            </h2>

            <p>
                Actualiza la información de tu usuario y correo electrónico.
            </p>
        </header>

        <!-- Formulario de datos del usuario -->
        <form @submit.prevent="submitUser" class="first-block-container">
            <div class="container-inputs">
                <div class="input-container">
                    <InputLabel for="first_name" value="Nombre"/>
                    <TextInput id="first_name" type="text" v-model="userForm.first_name" required autofocus autocomplete="given-name" />
                    <InputError :message="userForm.errors.first_name" class="error-text"/>
                </div>
                <div class="input-container">
                    <InputLabel for="last_name" value="Apellido"/>
                    <TextInput id="last_name" type="text" v-model="userForm.last_name" required autocomplete="family-name" />
                    <InputError :message="userForm.errors.last_name" class="error-text"/>
                </div>
                <div class="input-container">
                    <InputLabel for="email" value="Correo electrónico"/>
                    <TextInput id="email" type="email" v-model="userForm.email" required autocomplete="email" />
                    <InputError :message="userForm.errors.email" class="error-text"/>
                </div>
            </div>
            <div class="button-container">
                <PrimaryButton :disabled="userForm.processing" class="user">Guardar Usuario</PrimaryButton>
                <Transition enter-active-class="" enter-from-class="" leave-active-class="" leave-to-class="">
                    <p v-if="userForm.recentlySuccessful">Guardado.</p>
                </Transition>
            </div>
        </form>
    </section>

</template>
