<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

// Define props and emit for communication
const props = defineProps(["invoices", "currentClient"]);
const emit = defineEmits(["changePage"]);

// Page tracking
let page = ref(props.invoices.current_page || 1);

// Watch for changes in the invoices prop and reset the page to 1
watch(
    () => props.invoices.current_page,
    (newPage) => {
        page.value = newPage;
    },
    { immediate: true }
);

const prevPageSymbol = "&#x3c;";
const nextPageSymbol = "&#x3e;";

// Handle page change
const changePage = (pageIndex) => {
    if (pageIndex < 1 || pageIndex > props.invoices.last_page) return;

    page.value = pageIndex;

    // Update the page number in the URL
    router.visit(
        route("home", {
            page: pageIndex,
            client_id: props.currentClient || null, // Maintain the current client filter
        }),
        {
            preserveState: true,
            only: ["invoices"], // Only update the invoices section
        }
    );
};
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
            v-for="index in Array(props.invoices.last_page).keys()"
            :key="index"
            :class="
                page === index + 1
                    ? 'bg-primary text-white'
                    : 'bg-black/5 text-black'
            "
            class="border-[1px] border-black/50 font-bold px-2 py-1 rounded-lg text-sm disabled:cursor-not-allowed disabled:bg-black/20"
        >
            <span v-html="index + 1"></span>
        </button>

        <button
            @click="changePage(page + 1)"
            :disabled="page >= props.invoices.last_page"
            class="bg-black/5 border-[1px] border-black/50 font-bold text-black px-2 py-1 rounded-lg text-sm disabled:cursor-not-allowed disabled:bg-black/20"
        >
            <span v-html="nextPageSymbol"></span>
        </button>
    </div>
</template>
