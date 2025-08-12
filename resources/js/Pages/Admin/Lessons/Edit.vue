<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Form from './Form.vue';

const props = defineProps({
    lesson: Object,
    units: Array
});
</script>

<template>

    <Head title="Editar Lección" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="">Editar Lección</h2>
            </div>
        </template>
        <div class="container-forms">
            <div class="title-forms">
                <div class="back">
                    <Link href="/lessons">
                    <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                    </Link>
                </div>
                <h1>Editar Lección</h1>
            </div>
            <div class="form-container">
                <Form :lesson="lesson" :units="units" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
