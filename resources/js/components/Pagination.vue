<script setup>
import { ref } from "vue";
let props = defineProps(["invoices"]);
console.log(props.invoices);
let page = ref(null);
const emit = defineEmits(["changePage"]);
const changePage = (pg) => {
    page.value = pg;
    emit("changePage", { page: pg });
};
</script>
<template>
    <div class="w-full flex justify-center items-center gap-3">
        <button
            v-for="(link, index) in props.invoices.links"
            :key="index"
            @click="changePage(index === 0 ? 1 : index)"
            class="bg-black/20 border-[1px] border-black/50 font-bold text-black px-2 py-1 rounded-lg text-sm"
            :class="link.active ? 'bg-primary text-white' : ''"
        >
            <span v-html="link.label"> </span>
        </button>
    </div>
</template>
