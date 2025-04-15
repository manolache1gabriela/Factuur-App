<script setup>
import { provide } from "vue";
import { Head } from "@inertiajs/vue3";
import Layout from "../components/Layout.vue";

const props = defineProps(["clients"]);
</script>

<template>
    <Head title="Factuur" lang="nl" />
    <Layout :clients="clients" />
</template>
