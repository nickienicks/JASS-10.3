<template>
  <!--   <admin-layout title="Admin">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Ingresos Mensuales
            </h2>
        </template>
        <div class="py-2">
            <div class="grid grid-cols-2 span-4">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="w-full overflow-x-auto">
                            <h1 class="p-2 text-3xl font-bold">
                                Ingreso Total Mes
                            </h1>
                           
                            <Table>
                                <template #tableHead>
                                    <TableHead class="px-4 py-3"
                                        >Fecha</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Ingreso total</TableHead
                                    >
                                </template>
                                <TableRow
                                    v-for="sumatoria in sumatorias"
                                    :key="sumatoria.id"
                                >
                                    <TableData>
                                        {{ sumatoria.months }}</TableData
                                    >
                                    <TableData> {{ sumatoria.sums }}</TableData>
                                </TableRow>
                            </Table>
                        </div>
                    </div>
                </section>

                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <h1 class="p-2 text-3xl font-bold">
                            Todos los Ingresos
                        </h1>
                        <div class="p-2 m-2">
                            <div class="flex justify-between">
                                <div class="flex-1">
                                    <div class="relative">
                                        <div
                                            class="absolute flex items-center ml-2 h-full"
                                        >
                                            <SearchIcon class="w-4 h-4" />
                                        </div>

                                        <input
                                            type="date"
                                            v-model="search"
                                            class="px-8 py-3 w-full md:w-44 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
                                        />
                                    </div>
                                </div>
                                <div class="flex">
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
                                    <TableHead class="px-4 py-3">ID</TableHead>
                                    <TableHead class="px-4 py-3"
                                        >Fecha</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Monto</TableHead
                                    >
                                </template>
                                <TableRow
                                    v-for="pago in pagos.data"
                                    :key="pago.id"
                                >
                                    <TableData>{{ pago.id }}</TableData>
                                    <TableData> {{ pago.fecha }}</TableData>
                                    <TableData> {{ pago.monto }}</TableData>
                                </TableRow>
                            </Table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
    </admin-layout> -->
</template>

<script setup>
/* import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { ref, watch, defineProps } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { SearchIcon } from "@heroicons/vue/outline";
import Table from "../../../Components/Table.vue";
import TableData from "../../../Components/TableData.vue";
import TableHead from "../../../Components/TableHead.vue";
import TableRow from "../../../Components/TableRow.vue";

const props = defineProps({
    pagos: Object,
    sumatorias: Object,
    filters: Object,
});

const search = ref(props.filters.search);
const perPage = ref("");

watch(search, (value) => {
    Inertia.get(
        "/admin/ingresos",
        { search: value, perPage: perPage.value },
        {
            preserveState: true,
            replace: true,
        }
    );
});

function getContact() {
    Inertia.get(
        "/admin/ingresos",
        { perPage: perPage.value, search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
} */
</script>

<style></style>
