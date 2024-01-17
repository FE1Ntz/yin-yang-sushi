<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";

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
    <Layout>

    </Layout>
</template>

