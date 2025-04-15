<script setup>
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
let props = defineProps(["showModal"]);
let dialog = ref(null);
const openModal = () => {
    dialog.value.showModal();
};
const closeModal = () => {
    dialog.value.close();
};
defineExpose({ openModal });

const form = useForm({
    name: "",
    btw_number: "",
    address: "",
    add_btw: "",
});

const submit = () => {
    router.post(route("clients.store"), form, {
        onSuccess: () => {
            closeModal();
        },
        onError: () => {
            console.log("error");
        },
    });
};
</script>

<template>
    <dialog
        ref="dialog"
        class="w-1/2 h-1/2 rounded-2xl fixed m-auto shadow-2xl border-none backdrop:bg-black/35"
    >
        <div
            class="w-full h-full bg-white pt-2 px-5 relative flex flex-col md:flex-row justify-between py-2"
        >
            <button
                class="absolute top-4 right-4 text-gray-500 cursor-pointer"
                @click="closeModal"
            >
                <i class="pi pi-times-circle" style="font-size: 1.5rem"></i>
            </button>
            <form
                method="post"
                @submit.prevent="submit"
                class="w-full p-10 space-y-3 flex flex-col justify-between"
            >
                <p class="font-bold text-primary mt-8 text-lg">
                    Add client's information below:
                </p>
                <div class="flex flex-col justify-evenly gap-3 w-5/6">
                    <div class="flex items-center justify-between w-full">
                        <label for="client_name">Client's Name:</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="bg-black/10 px-4 py-2 rounded w-2/3"
                            placeholder="Paul Mheiner"
                        />
                    </div>
                    <div class="flex items-center justify-between w-full">
                        <label for="client_bwt">Client's BWT number:</label>
                        <input
                            type="text"
                            v-model="form.btw_number"
                            class="bg-black/10 px-4 py-2 rounded w-2/3"
                            placeholder="123.045.123"
                        />
                    </div>
                    <div class="flex items-center justify-between w-full">
                        <label for="client_address">Client's Address:</label>
                        <input
                            type="text"
                            v-model="form.address"
                            class="bg-black/10 px-4 py-2 rounded w-2/3"
                            placeholder="Weertstraat 15, 3800 Sint-Truiden"
                        />
                    </div>
                    <div class="flex items-center justify-between w-full">
                        <label
                            class="inline-flex items-center cursor-pointer flex-row-reverse gap-3"
                        >
                            <input
                                type="checkbox"
                                v-model="form.add_btw"
                                class="sr-only peer"
                            />
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"
                            ></div>
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-gray-300"
                                >BTW</span
                            >
                        </label>
                    </div>
                </div>
                <button
                    type="submit"
                    class="bg-primary self-end text-white hover:bg-black/50 rounded-2xl px-6 py-2 cursor-pointer"
                >
                    Save Client
                </button>
            </form>
        </div>
    </dialog>
</template>
