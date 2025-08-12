<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Form from './Form.vue';
</script>

<template>

    <Head title="Crear Nivel" />
    <AuthenticatedLayout>
        <template #header>
            <div class="">
                <h2 class="">Crear Nivel</h2>
            </div>
        </template>
        <div class="container-forms">
            <div class="title-forms">
                <div class="back">
                    <Link href="/levels">
                    <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                    </Link>
                </div>
                <h1>Crear Nivel</h1>
            </div>
            <div class="form-container">
                <Form />
            </div>
        </div>

    </AuthenticatedLayout>
</template>
