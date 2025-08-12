<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Form from './Form.vue';

const props = defineProps({
    resource: Object,
    units: Array
});
</script>

<template>

    <Head title="Editar Recurso" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar Recurso</h2>
            </div>
        </template>
        <div class="container-forms">
            <div class="form-wrapper">
                <div class="form-card">
                    <div class="form-content">
                        <div class="title-forms">
                            <div class="back">
                                <Link href="/resources">
                                <img src="/icons/return-icon.gif" alt="Regresar a la página anterior"
                                    class="btn-back" />
                                </Link>
                            </div>
                            <h1>Editar Recurso</h1>
                        </div>
                        <div class="form-container">
                            <Form :resource="resource" :units="units" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
