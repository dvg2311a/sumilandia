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

        <div class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                            <UpdateUserInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                                class="w-full" />
                        </div>
                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                            <UpdateProfileInformationForm class="w-full" />
                        </div>
                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                            <UpdatePasswordForm class="w-full" />
                        </div>
                    </div>
                    <div class="flex flex-col justify-between h-full">
                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 h-fit">
                            <DeleteUserForm class="w-full" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
