<template>
    <admin-layout title="Admin">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Deudas
            </h2>
        </template>
        <div class="py-2">
            <div class="mt-4 ml-6">
                <a
                    class="bg-red-500 hover:bg-red-700 px-4 py-2 rounded-lg text-white"
                    href="/admin/deudas/pdf"
                    target="_blank"
                    >Imprimir Facturas
                </a>
            </div>
            <div class="container">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
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
                                            type="text"
                                            v-model="search"
                                            placeholder="Ingrese un Nombre..."
                                            class="px-8 py-3 w-full md:w-2/6 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
                                        />
                                    </div>
                                </div>
                                <div class="flex">
                                    <select
                                        v-model="perPage"
                                        @change="getContact1"
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
                                        >Acciones</TableHead
                                    >
                                </template>
                                <TableRow
                                    v-for="contact in contacts.data"
                                    :key="contact.id"
                                >
                                    <TableData>{{
                                        contact.first_name
                                    }}</TableData>
                                    <TableData>
                                        {{ contact.last_name }}</TableData
                                    >
                                    <TableData> {{ contact.dni }}</TableData>

                                    <TableData>
                                        <div class="flex justify-around">
                                            <Link
                                                :href="
                                                    route(
                                                        'admin.deudas.view',
                                                        contact.id
                                                    )
                                                "
                                                class="bg-amber-500 hover:bg-amber-700 px-4 py-2 rounded-lg text-white"
                                            >
                                                ver
                                            </Link>
                                            <Link
                                                :href="
                                                    route(
                                                        'admin.deudas.create',
                                                        contact.id
                                                    )
                                                "
                                                class="bg-blue-600 hover:bg-blue-900 px-4 py-2 rounded-lg text-white"
                                            >
                                                Agregar Deuda
                                            </Link>
                                            <Link
                                                :href="
                                                    route(
                                                        'admin.deudas.corte_manual_view',
                                                        contact.id
                                                    )
                                                "
                                                class="bg-red-500 hover:bg-red-700 px-4 py-2 rounded-lg text-white"
                                            >
                                                Agregar Corte
                                            </Link>
                                        </div>
                                    </TableData>
                                </TableRow>
                            </Table>
                        </div>
                    </div>
                </section>
            </div>
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
const props = defineProps({
    contacts: Object,
    filters: Object,
});
const search = ref(props.filters.search);
const perPage = ref("");


watch(search, (value) => {
    router.get(
        "/admin/deudas",
        { perPage: perPage.value, search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
function getContact1() {
    router.get(
        "/admin/deudas",
        { perPage: perPage.value, search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
function getContact() {
    router.get(
        `/admin/deudas/${persona.id}/corte-manual/view,`,
        { perPage: perPage.value, search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
</script>

<style></style>