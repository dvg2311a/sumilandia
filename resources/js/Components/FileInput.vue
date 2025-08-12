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

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (event) => {
            preview.value = event.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        preview.value = null;
    }
}

if (typeof model.value === 'string' && model.value && !model.value.startsWith('data:')) {
    preview.value = model.value.startsWith('http') ? model.value : `/storage/${model.value.replace(/^public\//, '')}`;
}

onMounted(() => {
    if (input.value && input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div>
        <input type="file"
            class="file-input"
            @change="onFileChange" ref="input" />
        <div v-if="fileName" class="name-file">{{ fileName }}</div>
        <img v-if="preview" :src="preview" alt="Preview" class="file" />
    </div>
</template>
