<script setup>
import { ref } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

let props = defineProps(["row", "index"]);
const startDate = ref(new Date());
</script>
<style scoped>
.dp__theme_light {
    --dp-text-color: white;
    --dp-background-color: rgb(0 0 0 / 0.2);
    --dp-border-color: #ddd;
    --dp-font-family: "marcellus";
    --dp-border-radius: 8px;
    --dp-input-padding: 8px 20px 8px 20px;
    --dp-cell-padding: 0;
}
input,
select {
    cursor: pointer;
    border: 0;
}
</style>
<template>
    <div class="w-full flex items-center justify-between text-white flex-wrap">
        <span class="mr-1 text-primary font-bold">
            {{ index + 1 }}
        </span>
        <div>
            <VueDatePicker
                v-model="props.row.date"
                model-type="dd/MM/yyyy"
                :placeholder="startDate.toLocaleDateString('en-GB')"
                auto-apply
            />
        </div>
        <input
            class="bg-black/20 rounded-lg px-5 py-2 placeholder:text-white"
            type="text"
            placeholder="Omschrijving"
            v-model="props.row.service_materials"
            name="service_materials"
        />
        <input
            class="bg-black/20 rounded-lg px-5 py-2 placeholder:text-white"
            type="number"
            placeholder="Aantal"
            v-model="props.row.quantity"
            name="quantity"
            min="0.0"
            step="0.5"
        />
        <input
            class="bg-black/20 rounded-lg px-5 py-2 placeholder:text-white"
            type="number"
            placeholder="Prijs (€)"
            v-model="props.row.price"
            name="price"
            min="0.00"
            step="0.01"
        />
        <select
            name="BTW"
            id="btw"
            v-model="props.row.btw"
            class="px-8 py-2 bg-black/20 rounded-lg text-sm"
        >
            <option value="21">21%</option>
            <option value="6">6%</option>
        </select>
    </div>
</template>
