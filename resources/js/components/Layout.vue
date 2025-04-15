<script setup>
import ClientModal from "../components/ClientModal.vue";
import { ref, onMounted } from "vue";
let showModal = ref(false);
const props = defineProps(["clients"]);
let rows = ref(1);
const addRow = () => {
    rows.value += 1;
};
const openModal = () => {
    modal.value.openModal();
};
let modal = ref(null);
</script>

<template>
    <div class="flex flex-col justify-between items-center h-full w-full">
        <main class="w-full h-full p-4 flex items-center justify-between gap-5">
            <div
                class="bg-black/10 border-2 border-black/50 shadow-2xl/30 rounded-xl h-full w-1/3 flex flex-col justify-center items-center gap-4"
            >
                <div class="w-1/2 h-1/2 flex items-start justify-evenly">
                    <img
                        src="../../images/logo.svg"
                        alt="company logo"
                        width="100%"
                    />
                </div>
                <p class="text-center w-1/2 font-bold">
                    Add new client, if not found in the select options.
                </p>
                <button
                    class="bg-primary hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-10 rounded-full uppercase cursor-pointer"
                    @click="openModal"
                >
                    New Client
                </button>
            </div>
            <div
                class="flex flex-col items-center justify-between h-full w-2/3 gap-5"
            >
                <div
                    class="bg-black/10 border-2 border-black/50 shadow-2xl/30 rounded-xl h-1/5 w-full flex justify-between items-center px-[5%]"
                >
                    <div class="space-x-2">
                        <span class="font-bold text-lg"> Clients: </span>
                        <select
                            name="Clients"
                            id="clients"
                            class="px-6 py-2 bg-black/30 rounded-full text-white text-sm"
                        >
                            <option value="empty" selected></option>
                            <option
                                v-for="client in props.clients"
                                :key="client.id"
                                :value="client.name"
                            >
                                {{ client.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <button
                            class="bg-primary hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-10 rounded-full uppercase cursor-pointer"
                        >
                            Print
                        </button>
                    </div>
                </div>
                <div
                    class="bg-black/10 border-2 overflow-scroll p-7 border-black/50 shadow-2xl/30 rounded-xl h-4/5 w-full flex flex-col items-center space-y-4"
                >
                    <div
                        class="w-full flex items-center justify-between"
                        v-for="(row, index) in rows"
                        :key="index"
                    >
                        <span class="mr-2">
                            {{ row }}
                        </span>
                        <input
                            class="bg-black/20 rounded-lg px-5 py-2"
                            type="date"
                            placeholder="Date"
                            name="date"
                        />
                        <input
                            class="bg-black/20 rounded-lg px-5 py-2"
                            type="text"
                            placeholder="Service/Materials"
                            name="service_materials"
                        />
                        <input
                            class="bg-black/20 rounded-lg px-5 py-2"
                            type="number"
                            placeholder="Quantity"
                            name="quantity"
                            min="0.0"
                            step="0.5"
                        />
                        <input
                            class="bg-black/20 rounded-lg px-5 py-2"
                            type="number"
                            placeholder="Price (€)"
                            name="price"
                            min="0.00"
                            step="0.01"
                        />
                    </div>
                    <div
                        class="w-full h-12 rounded-lg bg-stripes bg-cover bg-no-repeat opacity-30"
                    ></div>
                    <button
                        class="bg-black/20 rounded-lg cursor-pointer w-full flex justify-center items-center py-2"
                        @click="addRow"
                    >
                        <i class="pi pi-plus" style="font-weight: 900"></i>
                    </button>
                </div>
            </div>
        </main>
        <ClientModal :show-modal="showModal" ref="modal" />
        <footer>
            <p class="text-xs font-bold pb-1">
                Copyright © {{ new Date().getFullYear() }}. All rights are
                reserved
            </p>
        </footer>
    </div>
</template>
