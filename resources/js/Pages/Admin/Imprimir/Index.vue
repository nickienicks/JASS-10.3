<template>
    <admin-layout title="Admin">
        <template #header>
            <h2
                class=" leading-tight container"
            >
                Imprimir Facturas
            </h2>
        </template>
        <section class=" ml-4 mt-4">
        <div class="py-2">
            <div class="mt-6 ml-6">
                <h3 class="font-semibold text-xl text-gray-800">
                    Imprimir todo:
                </h3>
            </div>
            <div class="mt-4 ml-6">
                <a
                    class="bg-zinc-500 hover:bg-zinc-700 px-4 py-2 rounded-lg text-white"
                    href="/admin/deudas/pdf"
                    target="_blank"
                    >Imprimir Facturas
                </a>
            </div>
            <div class="mt-8 ml-6">
                <h3 class="font-semibold text-xl text-gray-800">
                    Imprimir por zonas:
                </h3>
            </div>
            <div class=" flex mt-4 ml-6">
                <select 
                    class=" mt-1 block w-40 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    id="medidor_id"
                    type="text"
                    v-model="valueSelect" 
                    placeholder="Zona..."
                    
                    autofocus >
                        <option value="1">Zona 1</option>
                        <option value="2">Zona 2</option>
                        <option value="3">Zona 3</option>
                        <option value="4">Zona 4</option>
                        <option value="5">Zona 5</option>
                        <option value="6">Zona 6</option>
                        <option value="7">Zona 7</option>
                        <option value="8">Zona 8</option>
                        <option value="9">Zona 9</option>
                        <option value="10">Zona 10</option>
                </select>
            </div>
            <div class=" flex mt-6 ml-6 w-40">
                <a
                    class="bg-zinc-500 w-40 hover:bg-zinc-700 px-4 py-2 rounded-lg text-white"
                    :href="
                        route(
                            'admin.imprimir.pdf',
                            valueSelect
                        )
                    "
                    target="_blank"
                    >Imprimir  Zona  {{Cvalue.value}}
                </a>
                
            </div>
            
        </div>
        </section>
    </admin-layout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref, watch, defineProps, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { SearchIcon } from "@heroicons/vue/outline";
import Table from "../../../Components/Table.vue";
import TableData from "../../../Components/TableData.vue";
import TableHead from "../../../Components/TableHead.vue";
import TableRow from "../../../Components/TableRow.vue";
const props = defineProps({
    
});

const valueSelect = ref("");

const Cvalue = computed(() => {
    return valueSelect;
});

</script>


<style></style>