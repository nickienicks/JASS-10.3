<template>
    <admin-layout title="Admin">
        <template #header >
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Cortes
            </h2>
        </template>
        
            <div class=" ml-8 mt-4 relative">
                <button
                    onclick="window.print()"
                    hidden
                    class="bg-yellow-200  print:hidden text-yellow-900 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-yellow-300 duration-300"
                    >
                    Imprimir
                </button>
                <button
                    class="bg-yellow-200  print:hidden text-yellow-900 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-yellow-300 duration-300"
                    >
                    <a
                        href="/admin/cortes/pdf"
                        target="_blank"
                        >Imprimir 
                    </a>
                   
                </button>
            </div>
            <div class="container">
                <section class="container mx-auto mt-4 p-6 font-mono">
                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="p-2 m-2">
                            <div class="flex justify-between">
                                <div class="flex-1 print:hidden">
                                    <div class="relative ">
                                        <div
                                            class="absolute flex items-center ml-2 h-full"
                                        >
                                            <SearchIcon class="w-4 h-4 hidden" />
                                        </div>

                                        <input
                                            type="text"
                                            v-model="search"
                                            placeholder="Ingrese un Nombre..."
                                            class="px-8 hidden py-3 w-full md:w-2/6 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
                                        />
                                    </div>
                                </div>
                                <div class="flex print:hidden">
                                    <select
                                        v-model="perPage"
                                        @change="getContact"
                                        class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
                                    >
                                        <option value="5">5 Per Page</option>
                                        <option value="10">10 Per Page</option>
                                        <option value="15">15 Per Page</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="w-full overflow-x-auto">
                            <Table>
                                <template #tableHead>
                                    <TableHead class="px-4 py-3"
                                        >Nombres</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Apellidos</TableHead
                                    >
                                    <TableHead class="px-4 py-3">DNI</TableHead>

                                    <TableHead class="px-4 py-3"
                                        >Corte</TableHead
                                    >
                                </template>
                                <TableRow
                                    v-for="contact in dataa"
                                    :key="contact.id"
                                    
                                >
                                    <TableData>{{contact.first_name}}</TableData>
                                    <TableData>{{ contact.last_name }}</TableData>
                                    <TableData> {{ contact.dni }}</TableData>

                                    <TableData >
                                        <h1 v-if="contact.corte === ''">
                                            NADA
                                        </h1>
                                        <h1 v-else>
                                            CORTE
                                        </h1>
                                        
                                        </TableData>

                                </TableRow>

                            </Table>
                            <div v-for="deuda in contacts.deudas" :key="deuda.id">
                                {{deuda.fecha}}
                            </div>
                        </div>
                    </div>
                </section>
            
            </div>

        

        
    </admin-layout>

</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/vue3";
import { SearchIcon } from "@heroicons/vue/outline";
import Table from "../../../Components/Table.vue";
import TableData from "../../../Components/TableData.vue";
import TableHead from "../../../Components/TableHead.vue";
import TableRow from "../../../Components/TableRow.vue";
import DialogModal from "../../../Jetstream/DialogModal.vue";

const props = defineProps({
    contacts: Object,
    filters: Object,
    deudas:Object,
    fechau:Object,
    lastdeudass:Object,
});
const dataa= ref(props.contacts.data);
const search = ref(props.filters.search);

 
const perPage = ref("");

watch(search, (value) => {
    router.get(
        "/admin/cortes",
        { search: value, perPage: perPage.value },
        {
            preserveState: true,
            replace: true,
        }
    );
});

function getContact() {
    router.get(
        "/admin/cortes",
        { perPage: perPage.value, search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
</script>