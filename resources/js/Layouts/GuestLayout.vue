<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
const showImages = defineProps({
    showImage: {
        type: Boolean,
        default: true,
    }
})
</script>

<template>
    <!-- Clases de Tailwind del div:
     flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 -->
    <div class="container-main">
        <div>
                <ApplicationLogo v-if="showImage"/>
        </div>

        <div class="slot">
            <!--
            mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg
            -->
            <slot />
        </div>
    </div>
</template>
