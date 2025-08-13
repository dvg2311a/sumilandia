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

const profileForm = useForm({
    avatar: profile?.avatar || '',
    nickname: profile?.nickname || '',
    birthdate: profile?.birthdate || '',
    academic_level: String(profile?.academic_level || ''),
    gender: profile?.gender || '',
});

const submitProfile = () => {
    profileForm.nickname = String(profileForm.nickname || '');
    profileForm.birthdate = String(profileForm.birthdate || '');
    profileForm.academic_level = String(profileForm.academic_level || '');
    profileForm.gender = String(profileForm.gender || '');
    profileForm.post(route('profile.profile.update'), {
        forceFormData: true,
        onSuccess: () => {
            // profileForm.reset('avatar');
        },
    });
};
</script>

<template>
    <section>
        <header class="header-profile">
            <h2>
                Información de Perfil
            </h2>

            <p>
                Actualiza la información de tu perfil y correo electrónico.
            </p>
        </header>

        <!-- Formulario de datos del perfil -->
        <form @submit.prevent="submitProfile" enctype="multipart/form-data" class="first-block-container">
            <div class="container-image">
                <div>
                    <section>
                        <ImageInput id="avatar" v-model="profileForm.avatar" autocomplete="photo" class="" />
                    </section>
                    <InputError :message="profileForm.errors.avatar" class="error-text"/>
                </div>
            </div>
            <div class="container-inputs">
                <div class="input-container">
                    <InputLabel for="nickname" value="Apodo" />
                    <TextInput id="nickname" type="text" v-model="profileForm.nickname" autocomplete="nickname" />
                    <InputError :message="profileForm.errors.nickname" class="error-text"/>
                </div>
                <div class="input-container">
                    <InputLabel for="gender" value="Género" />
                    <select id="gender" v-model="profileForm.gender">
                        <option value="">Selecciona género</option>
                        <option value="male">Masculino</option>
                        <option value="female">Femenino</option>
                    </select>
                    <InputError :message="profileForm.errors.gender" class="error-text"/>
                </div>

                <div class="input-container">
                    <InputLabel for="birthdate" value="Fecha de nacimiento" />
                    <TextInput id="birthdate" type="date" v-model="profileForm.birthdate" autocomplete="bday" />
                    <InputError :message="profileForm.errors.birthdate" class="error-text"/>
                </div>
                <div class="input-container">
                    <InputLabel for="academic_level" value="Nivel académico" />
                    <TextInput id="academic_level" type="text" v-model="profileForm.academic_level" placeholder="1: Primaria, 2: Secundaria"/>
                    <InputError :message="profileForm.errors.academic_level" class="error-text"/>
                </div>
            </div>
            <div class="button-container">
                <PrimaryButton :disabled="profileForm.processing" >Guardar Perfil</PrimaryButton>
                <Transition enter-active-class="" enter-from-class="" leave-active-class="" leave-to-class="">
                    <p v-if="profileForm.recentlySuccessful" class="message">¡Guardado!</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
