<template>
    <admin-layout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Detalle de Deudas
            </h2>
        </template>

        <div class="py-2">
            <div class="container">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="w-full overflow-x-auto">
                            <div class="grid grid-cols-2 gap-8 p-4">
                                <div class="">
                                    <h1 class="text-2xl font-bold">
                                        Nombres y Apellidos:
                                    </h1>
                                    <div class="flex mt-4">
                                        <p class="text-xl">
                                            {{ persona.first_name }}
                                        </p>
                                        <p class="text-xl ml-2">
                                            {{ persona.last_name }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold">DNI:</h1>
                                    <div class="mt-4">
                                        <p class="text-xl">{{ persona.dni }}</p>
                                    </div>
                                </div>
                            </div>

                            <Table>
                                <template #tableHead>
                                    <TableHead class="px-4 py-3"
                                        >Fecha</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Lectura Anterior</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Lectura Actual</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Deuda</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Acciones</TableHead
                                    >
                                </template>
                                <TableRow
                                    v-for="deuda in deudas"
                                    :key="deuda.id"
                                    ><template
                                        v-if="deuda.monto === 0"
                                    ></template>
                                    <template v-else>
                                        <TableData v-if=" deuda.type == 1">
                                                        Corte y Reconexión
                                                    </TableData>
                                                    <TableData v-else>{{

                                                        deuda.fecha
                                                    }}</TableData>
                                        <TableData>{{
                                            deuda.medida_ant
                                        }}</TableData>
                                        <TableData>{{
                                            deuda.medida_act
                                        }}</TableData>
                                        <TableData> {{ deuda.monto }}</TableData
                                        ><TableData>
                                            <Link
                                                :href="
                                                    route('admin.deudas.edit', [
                                                        persona.id,
                                                        deuda.id,
                                                    ])
                                                "
                                                class="bg-green-500 hover:bg-green-700 px-4 py-2 rounded-lg text-white"
                                            >
                                                Editar
                                            </Link></TableData
                                        ></template
                                    >
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
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import Table from "../../../Components/Table.vue";
import TableData from "../../../Components/TableData.vue";
import { Link } from "@inertiajs/vue3";
import TableHead from "../../../Components/TableHead.vue";
import {
    PencilAltIcon,
    ArchiveIcon,
    DocumentAddIcon,
} from "@heroicons/vue/outline";
import TableRow from "../../../Components/TableRow.vue";
import { ref, watch, defineProps } from "vue";
const props = defineProps({
    persona: Object,
    deudas: Object,
    pagos: Object,
});
</script>