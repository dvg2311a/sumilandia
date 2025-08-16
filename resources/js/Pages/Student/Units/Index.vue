<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    levels: Array,
    units: Array,
    selectedLevel: [String, Number, null]
});

const levelId = ref(props.selectedLevel || '');

function handleLevelChange() {
    router.get(route('student.units.index'), { level_id: levelId.value });
}

function startUnit(id) {
    router.get(route('student.units.start', { id }));
}
</script>

<template>

    <Head title="Unidades" />
    <AuthenticatedLayout>
        <er-unit #header>
            <h2 class="">Unidades</h2>
        </er-unit>
        <div class="container-unit">
            <div class="container-title">
                <h1>¡Bienvenido, Estimado estudiante!</h1>
                <p>Esto es Sumilandia, una aplicación web donde aprenderás a:
                    sumar, restar, multiplicar, dividir y más...</p>
            </div>
            <div class="container-filter">
                <label class="">Filtrar por nivel: </label>
                <select v-model="levelId" @change="handleLevelChange" class="">
                    <option value="">Todos los niveles</option>
                    <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}
                    </option>
                </select>
            </div>
            <div class="container-cards">
                <div v-for="unit in units" :key="unit.id" class="cards">
                    <div class="card-content">
                        <div class="container-img">
                            <img :src="`/storage/${unit.image}`" alt="Imagen de la unidad"
                                class="card-image" />
                        </div>
                        <h2 class="">{{ unit.name }}</h2>
                        <p class="p">Nivel: <span class="font-semibold">{{
                            unit.level?.name ||
                                'Sin nivel' }}</span></p>
                        <div class="">
                            <span class="p">Progreso: </span>
                            <span :class="unit.progress === 100 ? 'blue-card' : unit.progress > 0 ? 'yellow' : 'gray'">
                                {{ unit.progress }}%
                            </span>
                            <div>
                                <span class="p">Estado: </span>
                                <span
                                    :class="unit.status === 'completado' ? 'blue-card' : unit.status === 'en_progreso' ? 'yellow' : 'gray'"> {{ unit.status === 'completado' ? 'Completado' : unit.status === 'en_progreso' ? 'En progreso' : 'No comenzado' }}
                                </span>
                            </div>
                            <p class="p">Tiempo estimado: <span class="font-semibold">{{ unit.expected_time ?
                                unit.expected_time + ' min' : 'No definido' }}</span></p>
                            <p class="">{{ unit.description }}</p>
                        </div>
                    </div>
                    <button class="btn-card" @click="startUnit(unit.id)">
                        Comenzar
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
