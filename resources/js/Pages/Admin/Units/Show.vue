<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    unit: Object
});
</script>

<template>

    <Head title="Detalle Unidad" />
    <AuthenticatedLayout>
        <div class="page-content">
            <div class="back">
            <Link href="/units" >
                <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back"/>
            </Link>
            </div>
            <div class="card">
                <div class="header-actions">
                    <h1>Detalle de la Unidad</h1>
                </div>
                <div class="unit-details">
                    <p><strong>ID:</strong> {{ unit.id }}</p>
                    <p><strong>Nombre:</strong> {{ unit.name }}</p>
                    <p><strong>Descripción:</strong> {{ unit.description }}</p>
                    <p><strong>Tiempo esperado:</strong> {{ unit.expected_time }} minutos</p>
                    <p><strong>Nivel:</strong> {{ unit.level?.name }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
