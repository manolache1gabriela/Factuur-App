<script setup>
let props = defineProps(["row", "index"]);
</script>
<template>
    <div class="w-full flex items-center justify-between">
        <span class="mr-2">
            {{ index + 1 }}
        </span>
        <input
            class="bg-black/20 rounded-lg px-5 py-2"
            type="date"
            placeholder="Date"
            v-model="props.row.date"
            name="date"
        />
        <input
            class="bg-black/20 rounded-lg px-5 py-2"
            type="text"
            placeholder="Service/Materials"
            v-model="props.row.service_materials"
            name="service_materials"
        />
        <input
            class="bg-black/20 rounded-lg px-5 py-2"
            type="number"
            placeholder="Quantity"
            v-model="props.row.quantity"
            name="quantity"
            min="0.0"
            step="0.5"
        />
        <input
            class="bg-black/20 rounded-lg px-5 py-2"
            type="number"
            placeholder="Price (€)"
            v-model="props.row.price"
            name="price"
            min="0.00"
            step="0.01"
        />
    </div>
</template>
