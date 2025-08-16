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
        <div class="container-unit">
            <div class="container-title">
                <h1>Listado de Lecciones</h1>
                <p>¡Selecciona una lección para comenzar!</p>
            </div>

            <div class="container-cards container-b">
                <div v-for="lesson in lessons" :key="lesson.id" class="cards">
                    <div class="card-content card-b">
                        <h2>{{ lesson.name }}</h2>
                        <p class="p">Progreso:
                            <span
                                :class="lesson.progress === 100 ? 'blue-card' : lesson.progress > 0 ? 'yellow' : 'gray'">
                                {{ lesson.progress }}%
                            </span>
                        </p>
                        <div>
                            <span class="p">Estado: </span>
                            <span
                                :class="lesson.status === 'completado' ? 'blue-card' : lesson.status === 'en_progreso' ? 'yellow' : 'gray'">
                                {{ lesson.status === 'completado' ? 'Completado' : lesson.status === 'en_progreso' ? 'En progreso' : 'No comenzado' }}
                            </span>
                        </div>
                        <p class="p">Descripción: <span class="font-semibold">{{ lesson.description }}</span></p>
                    </div>

                    <button class="btn-card" @click="$inertia.get(route('student.lessons.start', { id: lesson.id }))">
                        Iniciar lección
                    </button>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
