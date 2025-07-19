<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    unit: Object,
    lessons: Array
});
</script>

<template>

    <Head :title="`Lecciones de ${props.unit.name}`" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Lecciones de {{ props.unit.name }}</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">Listado de Lecciones</h1>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="lesson in lessons" :key="lesson.id"
                                class="bg-white shadow rounded-lg p-6 flex flex-col justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold mb-2">{{ lesson.name }}</h2>
                                    <p class="mb-2 text-gray-600">{{ lesson.description }}</p>
                                </div>
                                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                                    @click="$inertia.get(route('student.lessons.start', { id: lesson.id }))">
                                    Iniciar lección
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
