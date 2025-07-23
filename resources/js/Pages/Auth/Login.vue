<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const viewPassword = ref(null);

const showPassword = () => {
    if (viewPassword.value.src.includes('eyes-close-icon')) {
        viewPassword.value.src = 'icons/eyes-open-icon.png';
        document.getElementById('password').type = 'text';
        viewPassword.value.style.cursor = 'pointer';
    } else {
        viewPassword.value.src = 'icons/eyes-close-icon.png';
        document.getElementById('password').type = 'password';
    }
};
</script>

<template>


    <Head title="Iniciar sesión" />

    <div v-if="status" class="">
        {{ status }}
    </div>

    <form @submit.prevent="submit" class="form-login">

        <GuestLayout />
        <div class="text-login">
            <h1>Iniciar Sesión</h1>
        </div>
        <div class="element-login-container">


            <div class="items-login">
                <InputLabel for="email" value="Correo" />

                <div class="input-icon-container-login">
                    <img src="icons/user-icon.gif" alt="User Icon" class="gif-icons" />
                    <TextInput id="email" type="email" class="" v-model="form.email" required autofocus
                    autocomplete="username" />
                </div>

                    <InputError class="" :message="form.errors.email" />
            </div>

            <div class="items-login">
                <InputLabel for="password" value="Contraseña" />

                <div class="input-icon-container-login">

                    <img src="icons/password-icon.gif" alt="Lock Icon" class="gif-icons" />
                    <TextInput id="password" type="password" class="" v-model="form.password" required
                    autocomplete="current-password" />
                    <img src="icons/eyes-close-icon.png" alt="View Password" id="password" class="gif-icons" @click="showPassword" ref="viewPassword" />
                </div>

                <InputError class="" :message="form.errors.password" />
            </div>

        </div>

        <div class="end-card btn">
            <PrimaryButton class="btn-ok" :disabled="form.processing">
                Ingresar
            </PrimaryButton>
            <span class="question">
                ¿No tienes una cuenta? <br>
                <Link :href="route('register')" class="question link">Crear cuenta</Link>
            </span>
        </div>
    </form>
</template>
