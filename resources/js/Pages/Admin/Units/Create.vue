<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Form from './Form.vue';

const props = defineProps({
    levels: Array
});
</script>

<template>

    <Head title="Crear Unidad" />
    <AuthenticatedLayout>
        <template #header>
            <div class="header-container">
                <h2>Crear Unidad</h2>
            </div>
        </template>

        <div class="container-forms">
            <div class="title-forms">
                <div class="back">
                    <Link href="/units">
                    <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                    </Link>
                </div>
                <h1>Crear Unidad</h1>
            </div>
            <div class="form-container">
                <Form :levels="levels" />
            </div>
        </div>

    </AuthenticatedLayout>
</template>
