<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateUserInformationForm from './Partials/UpdateUserInformationForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>

    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Profile
            </h2>
        </template>


        <div class="container-profile">
            <div class="container-forms-profile">
                <div class="form-space">
                    <UpdateProfileInformationForm class="" />
                </div>
                <div class="form-space">
                    <UpdateUserInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="w-full" />
                </div>
                <div class="form-space">
                    <UpdatePasswordForm class="" />
                </div>
            </div>

            <div class="form-space">
                <DeleteUserForm class="" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
