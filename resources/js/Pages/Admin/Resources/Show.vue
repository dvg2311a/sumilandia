<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    resource: Object
});
</script>

<template>

    <Head title="Detalle de Recurso" />
    <AuthenticatedLayout>
        <div class="page-content">
            <div class="back">
                <Link href="/resources">
                <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                </Link>
            </div>
            <div class="card">
                <div class="header-actions">
                    <h1>Detalles del recurso</h1>
                </div>
                <div class="unit-details">
                    <p><strong>ID</strong> {{ resource.id }}</p>
                    <p><strong>Nombre</strong> {{ resource.name }}</p>
                    <p><strong>Descripción:</strong> {{ resource.description }}</p>
                    <p><strong>Unidad:</strong> {{ resource.unit?.name }}</p>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
