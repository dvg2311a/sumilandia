<script setup>
import { ref, onMounted } from 'vue';

const model = defineModel({
    type: [File, String, Object],
    required: true,
});

const input = ref(null);
const preview = ref(null);
const fileName = ref('');

function onFileChange(e) {
    const file = e.target.files[0];
    if (!file) {
        model.value = '';
        preview.value = null;
        fileName.value = '';
        return;
    }
    fileName.value = file.name;
    model.value = file;
    console.log('Archivo seleccionado:', file);
    const reader = new FileReader();
    reader.onload = (event) => {
        preview.value = event.target.result;
    };
    reader.readAsDataURL(file);
}

if (typeof model.value === 'string' && model.value && !model.value.startsWith('data:')) {
    preview.value = model.value.startsWith('http') ? model.value : `/storage/${model.value.replace(/^public\//, '')}`;
}

onMounted(() => {
    // Removed autofocus logic to prevent conflicts
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div>
        <input type="file" accept="image/*"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
            @change="onFileChange" ref="input" />
        <div v-if="fileName" class="mt-2 text-xs text-gray-400">{{ fileName }}</div>
        <img v-if="preview" :src="preview" alt="Preview" class="mt-2 max-h-40 rounded-md border" />
    </div>
</template>
