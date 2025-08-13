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
        <img v-if="preview" :src="preview" alt="Preview" class="" />
        <label for="image" class="label-image">Cambiar foto</label>
        <input type="file" accept="image/*" id="image"
            class="" @change="onFileChange" ref="input" />
        <div v-if="fileName" class="">{{ fileName }}</div>
    </div>
</template>
