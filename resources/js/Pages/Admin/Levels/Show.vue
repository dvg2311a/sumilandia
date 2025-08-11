<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    level: Object
});
</script>

<template>

    <Head title="Detalle Nivel" />
    <AuthenticatedLayout>
        <div class="page-content">
            <div class="back">
                <Link href="/levels">
                <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                </Link>
            </div>
            <div class="card">
                <div class="header-actions">
                    <h1>Detalle del Nivel</h1>
                </div>
                <div class="unit-details">
                    <p><strong>Nombre:</strong> {{ level.name }}</p>
                    <p><strong>Descripción:</strong> {{ level.description }}</p>
                    <p><strong>ID:</strong> {{ level.id }}</p>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
