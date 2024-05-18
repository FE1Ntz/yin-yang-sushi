<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <DefaultLayout></DefaultLayout>
</template>

