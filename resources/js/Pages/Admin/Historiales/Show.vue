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
                        </div>
                    </div>
                    <div class="mb-4">
                        <h1>Deudas</h1>
                        <Table>
                            <template #tableHead>
                                <TableHead class="px-4 py-3">Fecha</TableHead>
                                <TableHead class="px-4 py-3"
                                    >Lectura Anterior</TableHead
                                >
                                <TableHead class="px-4 py-3"
                                    >Lectura Actual</TableHead
                                >
                                <TableHead class="px-4 py-3">Deuda</TableHead>
                            </template>
                            <TableRow v-for="deuda in deudas" :key="deuda.id">
                                <TableData>{{ deuda.fecha }}</TableData>
                                <TableData>{{ deuda.medida_ant }}</TableData>
                                <TableData>{{ deuda.medida_act }}</TableData>
                                <TableData> {{ deuda.monto }}</TableData>
                            </TableRow>
                        </Table>
                    </div>
                    <h1>Pagos</h1>
                    <Table>
                        <template #tableHead>
                            <TableHead class="px-4 py-3">Fecha</TableHead>

                            <TableHead class="px-4 py-3">Monto</TableHead>
                        </template>
                        <TableRow v-for="pago in pagos" :key="pago.id">
                            <TableData>{{ pago.fecha }}</TableData>

                            <TableData> {{ pago.monto }}</TableData>
                        </TableRow>
                    </Table>
                </section>
            </div>
        </div>
    </admin-layout>
</template>

<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import Table from "../../../Components/Table.vue";
import TableData from "../../../Components/TableData.vue";
import TableHead from "../../../Components/TableHead.vue";

import TableRow from "../../../Components/TableRow.vue";
import { ref, watch, defineProps } from "vue";

const props = defineProps({
    persona: Object,
    deudas: Object,
    pagos: Object,
});
</script>
