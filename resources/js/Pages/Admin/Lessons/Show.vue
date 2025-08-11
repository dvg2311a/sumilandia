<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    lesson: Object
});
</script>

<template>

    <Head title="Detalle Lección" />
    <AuthenticatedLayout>
        <div class="page-content">
            <div class="back">
                <Link href="/lessons">
                <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                </Link>
            </div>
            <div class="card">
                <div class="header-actions">
                    <h1>Detalle de la Lección</h1>
                </div>
                <div class="unit-details">
                    <p><strong>ID:</strong> {{ lesson.id }}</p>
                    <p><strong>Nombre:</strong> {{ lesson.name }}</p>
                    <p><strong>Descripción:</strong> {{ lesson.description }}</p>
                    <p><strong>Unidad:</strong> {{ lesson.unit?.name }}</p>
                    <p><strong>Contenido:</strong> {{ lesson.content }}</p>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
