<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
let props = defineProps(["invoices"]);
console.log(props.invoices);
const emit = defineEmits(["changePage"]);
const changePage = (pageIndex) => {
    page.value = pageIndex;
    router.visit(
        route("home", {
            page: pageIndex,
        }),
        {
            preserveState: true,
            only: ["invoices"],
        }
    );
};
let prevPageSymbol = "&#x3c;";
let nextPageSymbol = "&#x3e;";

let page = ref(1);
</script>
<template>
    <div
        class="w-full flex justify-center items-center gap-3"
        v-if="props.invoices.data.length > 0"
    >
        <button
            @click="changePage(page - 1)"
            :disabled="page <= 1"
            class="bg-black/5 border-[1px] border-black/50 font-bold text-black px-2 py-1 rounded-lg text-sm disabled:cursor-not-allowed disabled:bg-black/20"
        >
            <span v-html="prevPageSymbol"></span>
        </button>
        <button
            @click="changePage(index + 1)"
            v-for="index in Array(invoices.last_page).keys()"
            :key="index"
            :class="
                page == index + 1
                    ? 'bg-primary text-white'
                    : 'bg-black/5 text-black'
            "
            class="border-[1px] border-black/50 font-bold px-2 py-1 rounded-lg text-sm disabled:cursor-not-allowed disabled:bg-black/20"
        >
            <span v-html="index + 1"></span>
        </button>
        <button
            @click="changePage(page + 1)"
            :disabled="page >= invoices.last_page"
            class="bg-black/5 border-[1px] border-black/50 font-bold text-black px-2 py-1 rounded-lg text-sm disabled:cursor-not-allowed disabled:bg-black/20"
        >
            <span v-html="nextPageSymbol"></span>
        </button>
    </div>
</template>
