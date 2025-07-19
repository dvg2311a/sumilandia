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
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Unidades</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">Listado de Unidades</h1>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold">Filtrar por nivel:</label>
                            <select v-model="levelId" @change="handleLevelChange" class="border rounded px-3 py-2">
                                <option value="">Todos los niveles</option>
                                <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}
                                </option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="unit in units" :key="unit.id"
                                class="bg-white shadow rounded-lg p-6 flex flex-col justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold mb-2">{{ unit.name }}</h2>
                                    <p class="mb-2 text-gray-600">{{ unit.description }}</p>
                                    <p class="text-sm text-gray-500">Nivel: <span class="font-semibold">{{
                                            unit.level?.name ||
                                            'Sin nivel' }}</span></p>
                                    <p class="text-sm text-gray-500">Tiempo estimado: <span class="font-semibold">{{ unit.expected_time ? unit.expected_time + ' min' : 'No definido' }}</span></p>
                                </div>
                                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                                    @click="startUnit(unit.id)">
                                    Comenzar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
