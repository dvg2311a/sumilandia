<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';

const form = useForm({
    first_name: '',
    last_name: '',
    academic_level: '',
    birthdate: '',
    email: '',
    gender: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

// ? Function to icon of calendar
const birthdateInput = ref(null);

function focusDateInput() {
    birthdateInput.value?.showPicker?.();
}

const selectHiden = ref(null);

// ? Function to hide the select option
// * This function is used to hide the select option when the user clicks on it
const btnSelect = () => {
    selectHiden.value.style.display = 'none';
}

</script>

<template>
    <GuestLayout :showImage="false">

        <Head title="Registro" />

        <form @submit.prevent="submit" class="form-register">
            <div class="title-register">
                <h1>Registro</h1>
            </div>
            <!--
                ? Nombres y apellidos
            -->
            <div class="elements-container">
                <div>
                    <InputLabel for="first_name" value="Nombres" class="text-labels" />
                    <!-- ? Contenedor del input y el icono -->
                    <div class="input-icon-container">
                        <img src="icons/names.gif" alt="lapiz-icon" class="gif-icons" />
                        <TextInput id="first_name" type="text" v-model="form.first_name" required
                            autocomplete="given-name" class="inputs" />
                    </div>
                </div>
                <InputError :message="form.errors.first_name" />

                <!-- * Apellido -->
                <div>
                    <InputLabel for="last_name" value="Apellidos" class="text-labels" />
                    <!-- ? Contenedor del input y el icono -->
                    <div class="input-icon-container">
                        <img src="icons/names.gif" alt="lapiz-icon" class="gif-icons" />
                        <TextInput id="last_name" type="text" v-model="form.last_name" required
                            autocomplete="family-name" class="inputs" />
                    </div>
                    <InputError :message="form.errors.last_name" />
                </div>
            </div>

            <!-- ? Academic Level and birthdate -->
            <div class="elements-container">

                <div>
                    <InputLabel for="academic-level" value="Grado Académico" class="text-labels" />
                    <div class="input-icon-container">
                        <img src="icons/grade-icon.gif" alt="" class="gif-icons">
                        <select id="academic-level" v-model="form.academic_level" required class="inputs">
                            <option value="">Selecciona grado académico</option>
                            <option value="primary">Primaria</option>
                            <option value="secondary">Secundaria</option>
                        </select>
                    </div>
                    <InputError :message="form.errors.academic_level" />
                </div>

                <div>
                    <InputLabel for="birthdate" value="Fecha de Nacimiento" class="text-labels" />
                    <!-- ? Contenedor del input y el icono -->
                    <div class="input-icon-container">
                        <img src="icons/calendar-icon.gif" class="gif-icons" @click="focusDateInput" />
                        <TextInput id="birthdate" type="date" v-model="form.birthdate" class="inputs"
                            ref="birthdateInput" />
                    </div>
                    <InputError :message="form.errors.birthdate" />
                </div>
            </div>

            <!-- ? Email and gender -->
            <div class="elements-container">

                <div>
                    <InputLabel for="email" value="Correo" class="text-labels" />

                    <div class="input-icon-container">
                        <img src="icons/mail-icon.gif" alt="" class="gif-icons">
                        <TextInput id="email" type="email" v-model="form.email" required autocomplete="username"
                            class="inputs" />
                    </div>
                    <InputError :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="gender" value="Sexo" class="text-labels" />

                    <div class="input-icon-container">
                        <Dropdown v-model="form.gender">
                            <template #trigger>
                                <div class="">
                                    <span v-if="form.gender === 'male'" class="gender-containerIf">
                                        <img src="icons/male-icon.gif" class="gif-icons" /> Niño
                                    </span>
                                    <span v-else-if="form.gender === 'female'" class="gender-containerIf">
                                        <img src="icons/female-icon.gif" class="gif-icons" /> Niña
                                    </span>
                                    <span v-else class=" select" @click="btnSelect" ref="selectHiden">Seleccione su sexo <img src="icons/chevron-down.svg" alt="Icon Arrow dropdown"></span>
                                </div>
                            </template>

                            <template #content>
                                <ul class="dropdown">
                                    <li @click="form.gender = 'male'"
                                        class="gender-container">
                                        <img src="icons/male-icon.gif" class="gif-icons" /> Niño
                                    </li>
                                    <li @click="form.gender = 'female'"
                                        class="gender-container">
                                        <img src="icons/female-icon.gif" class="gif-icons" /> Niña
                                    </li>
                                </ul>
                            </template>
                        </Dropdown>
                    </div>

                    <InputError :message="form.errors.gender" />
                </div>

            </div>

            <!-- ? Password and password confirmation -->
            <div class="elements-container">

                <div>
                    <InputLabel for="password" value="Contraseña" class="text-labels" />
                    <div class="input-icon-container">
                        <img src="icons/password-icon.gif" alt="" class="gif-icons">
                        <TextInput id="password" type="password" v-model="form.password" required
                            autocomplete="new-password" class="inputs" />
                    </div>
                    <InputError :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirmar contraseña" class="text-labels" />
                    <div class="input-icon-container">
                        <img src="icons/password-icon.gif" alt="" class="gif-icons">
                        <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation"
                            required autocomplete="new-password" class="inputs" />
                    </div>
                    <InputError :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div class="end-card">
                <PrimaryButton class="btn-ok" :disabled="form.processing">
                    Registrarse
                </PrimaryButton>
                <span class="question">
                    ¿Ya tienes una cuenta? <br>
                    <Link :href="route('login')" class="question link">Iniciar sesión</Link>
                </span>

            </div>
        </form>


    </GuestLayout>
</template>
