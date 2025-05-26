<script setup>
import { router, usePage } from "@inertiajs/vue3";
import ClientModal from "../components/ClientModal.vue";
import EditClientModal from "../components/EditClientModal.vue";
import InvoiceRow from "../components/InvoiceRow.vue";
import { ref, computed, onMounted } from "vue";
import Pagination from "./Pagination.vue";
const props = defineProps(["clients", "invoices"]);
let showModalCreate = ref(false);
let showModalEdit = ref(false);
let modal1 = ref(null);
let modal2 = ref(null);
let currentInvoice = ref(null);
let invoiceClient = ref(null);
let rowsData = ref([
    {
        date: new Date().toLocaleDateString("en-GB"),
        service_materials: "",
        quantity: "",
        price: "",
        btw: 21,
    },
]);
let data = {
    date: new Date().toLocaleDateString("en-GB"),
    service_materials: "",
    quantity: "",
    price: "",
    btw: 21,
};

let form = ref({
    currentClient: 0,
    location: "",
    rows: rowsData.value,
});

const print = () => {
    router.post(
        route("invoice.store"),
        {
            currentClient: form.value.currentClient,
            location: form.value.location,
            rows: rowsData.value,
        },
        {
            onSuccess: (response) => {
                rowsData.value = [Object.assign({}, data)];
                form.value = {
                    currentClient: form.value.currentClient,
                    location: "",
                    rows: rowsData.value,
                };
                router.visit(
                    route("home", {
                        client_id: form.value.currentClient,
                    }),
                    {
                        preserveState: true,
                        only: ["invoices"],
                    }
                );
            },
            onError: (error) => {
                console.log(error);
            },
        }
    );
};

const addRow = () => {
    rowsData.value.push(Object.assign({}, data));
};
const openModalCreateClient = () => {
    modal1.value.openModalCreate();
};
const openModalEditClient = () => {
    modal2.value.openModalEdit();
};

const selectCurrentClient = (e) => {
    cancelUpdate();
    router.visit(
        route("home", {
            client_id:
                form.value.currentClient === 0
                    ? null
                    : form.value.currentClient,
        }),
        {
            preserveState: true,
            only: ["invoices", "form"],
        }
    );

    if (form.value.currentClient === 0) {
        invoiceClient.value = null;
    }
};

let canEditClient = computed(() => {
    return form.value.currentClient === 0;
});

let editInAllClients = computed(() => {
    if (form.value.currentClient !== 0 || currentInvoice.value !== null) {
        return true;
    }
    return false;
});

const editInvoice = (invoiceId) => {
    currentInvoice.value = invoiceId;
    let invoice = props.invoices.data.filter((el) => el.id === invoiceId)[0];
    form.value.location = invoice.location;
    rowsData.value = invoice.data;
    form.value.rows = rowsData.value;
    if (form.value.currentClient == 0) {
        invoiceClient.value = invoice.client.id;
    }
};
const cancelUpdate = () => {
    currentInvoice.value = null;
    form.value.location = "";
    rowsData.value = [
        {
            date: new Date().toLocaleDateString("en-GB"),
            service_materials: "",
            quantity: "",
            price: "",
            btw: 21,
        },
    ];
};

const updateInvoice = () => {
    router.put(
        route("invoice.update", { invoice: currentInvoice.value }),
        {
            currentClient:
                form.value.currentClient === 0
                    ? invoiceClient.value
                    : form.value.currentClient,
            location: form.value.location,
            rows: rowsData.value,
        },
        {
            onSuccess: (response) => {
                rowsData.value = [Object.assign({}, data)];
                form.value = {
                    currentClient: form.value.currentClient,
                    location: "",
                    rows: rowsData.value,
                };
                currentInvoice.value = null;
                invoiceClient.value = 0;
                router.visit(
                    route("home", {
                        client_id: form.value.currentClient,
                    }),
                    {
                        preserveState: true,
                        only: ["invoices"],
                    }
                );
            },
            onError: (error) => {
                console.log(error);
            },
        }
    );
};

const changePage = (e) => {
    console.log(e.page);
    router.visit(
        route("home", {
            page: e.page,
        }),
        {
            preserveState: true,
            only: ["invoices"],
        }
    );
};

const deleteClient = (clientId) => {
    router.delete(route("clients.delete", { client: clientId }), {
        onSuccess: () => {
            router.visit(route("home"), {
                preserveState: true,
                only: ["clients", "invoices"],
            });
            form.value.currentClient = 0;
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
};

onMounted(() => {
    form.value.currentClient = usePage().props.client_id || 0;
});
</script>

<template>
    <div class="flex flex-col justify-between items-center h-full w-full">
        <main class="w-full h-full p-4 flex items-center justify-between gap-5">
            <div
                class="bg-black/10 border-2 border-black/50 shadow-2xl/30 rounded-xl h-full w-1/3 flex flex-col justify-evenly items-center"
            >
                <div class="w-full h-1/4 flex items-start justify-center">
                    <img
                        src="../../images/logo.svg"
                        alt="company logo"
                        class="h-full"
                    />
                </div>
                <div class="w-full space-x-2 px-2 flex flex-col items-center">
                    <span class="font-bold text-3xl mb-2"> Klanten:</span>
                    <select
                        @change="selectCurrentClient"
                        v-model="form.currentClient"
                        name="Clients"
                        id="clients"
                        class="w-3/4 px-6 py-2 bg-black/20 rounded-full text-white text-sm"
                    >
                        <option
                            v-for="client in props.clients"
                            :key="client.id"
                            :value="client.id"
                        >
                            {{ client.name }}
                        </option>
                    </select>
                    <div
                        class="w-full flex flex-col text-lg justify-center items-center mt-2"
                        v-show="form.currentClient !== 0"
                    >
                        <p>
                            Addres:
                            {{ props.clients[form.currentClient].address }}
                        </p>
                        <p v-if="props.clients[form.currentClient].btw_number">
                            BTW nummer:
                            {{ props.clients[form.currentClient].btw_number }}
                        </p>
                        <p>
                            Heeft BTW:
                            {{
                                props.clients[form.currentClient].has_btw == 1
                                    ? "Ja"
                                    : "Nee"
                            }}
                        </p>
                    </div>
                </div>
                <div
                    class="w-full flex flex-col items-center justify-between"
                    v-show="form.currentClient == 0"
                >
                    <p class="text-center w-1/2 font-bold mb-2">
                        Voeg een nieuwe klant toe als deze niet in de
                        selectieopties staat.
                    </p>
                    <button
                        class="bg-primary hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-10 rounded-full uppercase cursor-pointer"
                        @click="openModalCreateClient"
                    >
                        Nieuwe Klant
                    </button>
                </div>
                <div
                    class="w-2/3 flex items-center justify-between text-xs"
                    v-show="form.currentClient !== 0"
                >
                    <button
                        class="bg-primary hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-10 rounded-full uppercase cursor-pointer"
                        @click="openModalEditClient"
                    >
                        Klant Bewerken
                    </button>
                    <button
                        @click="deleteClient(form.currentClient)"
                        class="bg-red-400 hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-8 rounded-full uppercase cursor-pointer"
                    >
                        Klant Verwijderen
                    </button>
                </div>
            </div>
            <div
                class="flex flex-col items-center justify-between h-full w-2/3 gap-5"
            >
                <div
                    class="bg-black/10 border-2 border-black/50 shadow-2xl/30 rounded-xl h-2/5 w-full flex flex-col justify-center items-center gap-1 pb-1"
                >
                    <table class="w-full h-full text-black/75 text-center">
                        <thead class="border-b-[1px] border-black/60">
                            <tr>
                                <th class="border-r-[1px] border-black/60">
                                    Factuur Nummer
                                </th>
                                <th class="border-r-[1px] border-black/60">
                                    Factuurdatum
                                </th>
                                <th
                                    class="border-r-[1px] border-black/60"
                                    v-if="canEditClient"
                                >
                                    Klant Naam
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <td
                                colspan="3"
                                class="text-2xl tex-center p-10"
                                v-if="props.invoices.data < 1"
                            >
                                Geen Factuur
                            </td>
                            <tr
                                class="border-b-[0.5px] border-black/20"
                                v-for="invoice in props.invoices.data"
                                :key="invoice.id"
                            >
                                <td class="border-r-[1px] border-black/20">
                                    {{ invoice.id }}
                                </td>

                                <td class="border-r-[1px] border-black/20">
                                    {{
                                        new Date(
                                            invoice.updated_at
                                        ).toLocaleDateString("en-GB")
                                    }}
                                </td>
                                <td
                                    v-if="canEditClient"
                                    class="border-r-[1px] border-black/20"
                                >
                                    {{ invoice.client?.name }}
                                </td>
                                <td
                                    class="bg-black/25 border-r-[1px] border-black/20"
                                >
                                    <button @click="editInvoice(invoice.id)">
                                        Bewerking
                                    </button>
                                </td>
                                <td class="bg-black/25">
                                    <a
                                        :href="
                                            route('download', {
                                                invoice: invoice.id,
                                            })
                                        "
                                        target="_blank"
                                        rel="noopener"
                                        >Downloaden</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination
                        @change-page="changePage"
                        :invoices="props.invoices"
                        :currentClient="form.currentClient"
                    />
                </div>
                <div
                    class="bg-black/10 border-2 border-black/50 shadow-2xl/30 rounded-xl h-3/5 w-full"
                >
                    <div
                        v-show="editInAllClients"
                        class="w-full h-full flex flex-col items-center gap-4 p-7 overflow-scroll"
                    >
                        <div class="w-full flex items-center justify-between">
                            <div class="w-1/3 space-x-2 flex items-center">
                                <span class="font-bold text-lg"
                                    >Locatie/Werf nummer:</span
                                >
                                <input
                                    type="text"
                                    v-model="form.location"
                                    class="w-full px-4 py-2 bg-black/20 rounded-full text-white text-sm"
                                    placeholder="Gasthuisstraat 1, 2400 Mol"
                                />
                            </div>
                            <div
                                class="w-1/3 space-x-2 flex items-center"
                                v-show="canEditClient"
                            >
                                <span class="font-bold text-lg"> Klant:</span>
                                <select
                                    v-model="invoiceClient"
                                    name="Client"
                                    id="client"
                                    class="px-3 py-2 w-3/4 bg-black/20 rounded-full text-white text-sm"
                                >
                                    <option
                                        v-for="client in props.clients"
                                        :key="client.id"
                                        :value="client.id"
                                        :disabled="client.id === 0"
                                    >
                                        {{ client.name }}
                                    </option>
                                </select>
                            </div>
                            <div
                                class="flex items-center justify-between text-sm w-1/4"
                            >
                                <button
                                    v-if="currentInvoice"
                                    @click="cancelUpdate"
                                    class="bg-red-300 hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-4 rounded-full uppercase cursor-pointer"
                                >
                                    Annuleren
                                </button>
                                <button
                                    v-if="currentInvoice == null"
                                    @click="print"
                                    class="bg-primary hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-10 rounded-full uppercase cursor-pointer"
                                >
                                    Opslaan
                                </button>
                                <button
                                    v-if="currentInvoice"
                                    @click="updateInvoice"
                                    class="bg-primary hover:bg-gray-500 border-2 border-gray-500 text-white py-2 px-4 rounded-full uppercase cursor-pointer"
                                >
                                    Update
                                </button>
                            </div>
                        </div>
                        <InvoiceRow
                            v-for="(row, index) in rowsData"
                            :key="index"
                            :index="index"
                            :row="row"
                        />
                        <div
                            class="w-full h-12 rounded-lg bg-stripes bg-cover bg-no-repeat opacity-30"
                        ></div>
                        <button
                            class="bg-black/20 rounded-lg cursor-pointer w-full bottom-0 flex justify-center items-center py-2"
                            @click="addRow"
                        >
                            <i class="pi pi-plus" style="font-weight: 900"></i>
                        </button>
                    </div>
                    <div
                        v-show="!editInAllClients"
                        class="w-full h-full flex justify-center items-center"
                    >
                        <p class="w-2/3 text-2xl text-center font-semibold">
                            Selecteer een klant om een factuur te maken. <br />
                            U kunt een factuur ook bewerken of downloaden uit de
                            bovenstaande lijst.
                        </p>
                    </div>
                </div>
            </div>
        </main>
        <ClientModal :show-modal-create="showModalCreate" ref="modal1" />
        <EditClientModal :show-modal-edit="showModalEdit" ref="modal2" />
        <footer>
            <p class="text-xs font-bold pb-1">
                Copyright © {{ new Date().getFullYear() }}. All rights are
                reserved
            </p>
        </footer>
    </div>
</template>
