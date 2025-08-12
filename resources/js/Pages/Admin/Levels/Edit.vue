<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Form from './Form.vue';

const props = defineProps({
    level: Object
});
</script>

<template>

    <Head title="Editar Nivel" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar Nivel</h2>
            </div>
        </template>
        <div class="container-forms">
            <div class="">
                <div class="">
                    <div class="title-forms">
                        <div class="back">
                            <Link href="/levels">
                            <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                            </Link>
                        </div>
                        <h1>Editar Nivel</h1>
                    </div>
                    <div class="form-container">
                        <Form :level="level" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
