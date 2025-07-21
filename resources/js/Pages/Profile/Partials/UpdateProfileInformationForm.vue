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
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Información de Perfil
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Actualiza la información de tu perfil y correo electrónico.
            </p>
        </header>

        <!-- Formulario de datos del perfil -->
        <form @submit.prevent="submitProfile" enctype="multipart/form-data" class="mt-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="avatar" value="Avatar" />
                    <ImageInput id="avatar" v-model="profileForm.avatar" class="mt-1 block w-full"
                        autocomplete="photo" />
                    <InputError class="mt-2" :message="profileForm.errors.avatar" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="nickname" value="Apodo" />
                    <TextInput id="nickname" type="text" class="mt-1 block w-full" v-model="profileForm.nickname"
                        autocomplete="nickname" />
                    <InputError class="mt-2" :message="profileForm.errors.nickname" />
                </div>
                <div>
                    <InputLabel for="gender" value="Género" />
                    <select id="gender" v-model="profileForm.gender"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Selecciona género</option>
                        <option value="male">Masculino</option>
                        <option value="female">Femenino</option>
                    </select>
                    <InputError class="mt-2" :message="profileForm.errors.gender" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="birthdate" value="Fecha de nacimiento" />
                    <TextInput id="birthdate" type="date" class="mt-1 block w-full" v-model="profileForm.birthdate"
                        autocomplete="bday" />
                    <InputError class="mt-2" :message="profileForm.errors.birthdate" />
                </div>
                <div>
                    <InputLabel for="academic_level" value="Nivel académico" />
                    <TextInput id="academic_level" type="text" class="mt-1 block w-full"
                        v-model="profileForm.academic_level" />
                    <InputError class="mt-2" :message="profileForm.errors.academic_level" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="profileForm.processing">Guardar Perfil</PrimaryButton>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="profileForm.recentlySuccessful" class="text-sm text-gray-600">¡Guardado!</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
