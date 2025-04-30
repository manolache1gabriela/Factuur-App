<script setup>
import { provide } from "vue";
import { Head } from "@inertiajs/vue3";
import Layout from "../components/Layout.vue";

const props = defineProps(["clients", "invoices"]);
</script>

<template>
    <Head title="Factuur" lang="nl" />
    <Layout :clients="props.clients" :invoices="props.invoices" />
</template>
