<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header class="header-profile">
            <h2>
                Cambiar contraseña
            </h2>

            <p>
                Asegúrate de usar una contraseña larga y segura para proteger tu cuenta.
            </p>
        </header>

        <!-- Formulario de cambio de contraseña -->
        <form @submit.prevent="updatePassword" class="first-block-container">
            <div class="container-inputs">
                <div class="input-container">
                    <InputLabel for="current_password" value="Contraseña actual" />
                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password" autocomplete="current-password" />
                    <InputError :message="form.errors.current_password" class="error-text"/>
                </div>

                <div class="input-container">
                    <InputLabel for="password" value="Nueva contraseña" />
                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        autocomplete="new-password" />
                    <InputError :message="form.errors.password" class="error-text"/>
                </div>

                <div class="input-container">
                    <InputLabel for="password_confirmation" value="Confirmar contraseña" />
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        autocomplete="new-password" />
                    <InputError :message="form.errors.password_confirmation" class="error-text"/>
                </div>
            </div>

            <div class="button-container">
                <PrimaryButton :disabled="form.processing" class="password">Guardar</PrimaryButton>

                <Transition enter-active-class="" enter-from-class="" leave-active-class="" leave-to-class="">
                    <p v-if="form.recentlySuccessful">
                        ¡Guardado!
                    </p>
                </Transition>
            </div>
        </form>
    </section>

</template>
