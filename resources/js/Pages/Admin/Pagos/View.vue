<template>
    <admin-layout class="">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container print:hidden"
            >
                Realizar un pago
            </h2>
        </template>

        <div class="py-2">
            <div class="container">
                <section class="container mx-auto p-6 font-mono print:hidden">
                    <div
                        class="w-full overflow-hidden bg-white rounded-lg shadow-lg"
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
                                        <p class="text-xl">
                                            {{ persona.dni }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 mt-10">
                                <h1 class="text-2xl font-bold">Deudas:</h1>
                                <div class="mt-4" v-if="deudas == 0">
                                    <p>NO exitste deudas</p>
                                </div>
                                <div v-else>
                                    <div class="w-full overflow-x-auto">
                                        <Table>
                                            <template #tableHead>
                                                <TableHead class="px-4 py-3"
                                                    >Fecha</TableHead
                                                >
                                                <TableHead class="px-4 py-3"
                                                    >Lect. Anterior</TableHead
                                                >
                                                <TableHead class="px-4 py-3"
                                                    >Lect. Actual</TableHead
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
                                                >
                                               
                                                <template
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
                                                    <TableData>
                                                        {{
                                                            deuda.monto
                                                        }}</TableData
                                                    >

                                                    <table-data>
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'admin.pagos.edit',
                                                                    [
                                                                        persona.id,
                                                                        deuda.id,
                                                                    ]
                                                                )
                                                            "
                                                            as="button"
                                                            type="button"
                                                            class="bg-green-500 hover:bg-green-700 px-4 py-2 rounded-lg text-white"
                                                        >
                                                            Pagar
                                                        </Link>
                                                    </table-data>
                                                </template>
                                            </TableRow>
                                            <Table-row class=" bg-gray-200">
                                                <table-data >
                                                   Total:
                                                </table-data>
                                                <table-data>
                                                    
                                                </table-data>
                                                <table-data>
                                                    
                                                </table-data>
                                                <table-data>
                                                    {{props.suma}}
                                                </table-data>
                                                <table-data>
                                                    
                                                </table-data>
                                            </Table-row>
                                        </Table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <button
                    v-if="!open"
                    @click="Open"
                    v-show="!open"
                    class="ml-6 bg-yellow-200 text-yellow-900 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-yellow-300 duration-300"
                >
                    Generar boleta
                </button>

                <div v-show="open">
                    <div class="mb-6 print:hidden">
                        <h1 class="ml-8 mx-auto font-mono print:hidden ">
                            Boleta de deuda total
                        </h1>
                    </div>
                    <section class="container mx-auto font-mono">
                        <form id="formu" @submit.prevent="storePagosBoleta">
                            <div class="w-auto bg-white rounded-lg shadow-lg mx-2">
                                <div class="w-full">
                                    <div class="flex justify-around">
                                        <div class="text-center">
                                            <h1 class="text-3xl font-bold">JASS</h1>
                                            <h1 class="text-3xl">
                                                CENTRO POBLADO "ALEGRIA"
                                            </h1>
                                            <h1 class="text-3xl font-bold">
                                                RECIBO DE INGRESO
                                            </h1>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex mb-1 justify-end">
                                                <div
                                                  class="text-sm text-red-400"
                                                   v-if="form.errors.monto"
                                                   >
                                                   {{ form.errors.monto }}
                                                </div>
                                                <div>
                                                    <label>S/.</label
                                                    ><input
                                                        class="rounded-lg"
                                                        type="text"
                                                        v-model="form.monto"
                                                    />
                                                </div>
                                                
                                            </div>
                                            <div class="flex mb-1 justify-end">
                                                <div
                                                    class="text-sm text-red-400"
                                                    v-if="form.errors.fecha"
                                                    >
                                                    {{ form.errors.fecha }}
                                                </div>
                                                <input class="rounded-lg" 
                                                    type="date" 
                                                    v-model="form.fecha"
                                                />
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border border-2 border-sky-500">
                                        <div class="flex items-center">
                                            <p class="w-1/4">Recibo de Sr(a):</p>

                                            <div
                                                class="border-b border-teal-500 w-1/2 py-2"
                                            >
                                                <input
                                                    class="appearance-none w-3/4 bg-transparent border-none text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                                    type="text"
                                                    :value=" persona.first_name + ' ' + persona.last_name "
                                                    
                                                    aria-label="Full name"
                                                />
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <p class="w-1/4">La cantidad de:</p>

                                            <div
                                                class="border-b border-teal-500 w-1/2 py-2"
                                            >
                                                <input
                                                    class="appearance-none w-3/4 bg-transparent border-none text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                                    type="text"
                                                    aria-label="Full name"
                                                    
                                                />
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-8 mt-2">
                                            <div>
                                                <p>Por concepto de:</p>
                                            </div>
                                            <div class="">
                                                <div class="my-4">
                                                    <input type="checkbox" />
                                                    <label for=""
                                                        >Cuota Mensual</label>
                                                
                                                </div>
                                                <div class="my-6">
                                                    <input type="checkbox" />
                                                    <label for=""
                                                        >Couta Extraordinaria</label
                                                    >
                                                </div>
                                                <div class="my-4">
                                                    <input type="checkbox" />
                                                    <label for=""
                                                        >Otros</label
                                                    >
                                                </div>
                                            </div>
                                            <div class="items-center">
                                                <div class="flex items-center">
                                                    <label class="" for=""
                                                        >S/.</label
                                                    >
                                                    <div
                                                        class="w-48 border-b border-teal-500 py-2"
                                                    >
                                                        <input
                                                            class="appearance-none bg-transparent border-none text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                                            type="text"
                                                            aria-label="Full name"
                                                        />
                                                        
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <label class="" for=""
                                                        >S/.</label
                                                    >
                                                    <div
                                                        class="border-b w-48 border-teal-500 py-2"
                                                    >
                                                        <input
                                                            class="appearance-none bg-transparent border-none text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                                            type="text"
                                                            aria-label="Full name"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <label class="" for=""
                                                        >S/.</label
                                                    >
                                                    <div
                                                        class="border-b w-48 border-teal-500 py-2"
                                                    >
                                                        <input
                                                            class="appearance-none bg-transparent border-none text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                                            type="text"
                                                            aria-label="Full name"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white flex justify-around border border-2 border-sky-500 mx-2"
                            >
                                <p>Recibo Conforme</p>
                                <p>V*B* Conformidad</p>
                            </div>
                            <div
                                class="bg-white flex justify-around border border-2 border-sky-500 mx-2 h-24"
                            >
                                <p>Sello y firma del Tesorero</p>
                                <p>Sello y firma del presidente></p>
                            </div>
                            <div class="flex ml-6">
                        <button
                        type="button"
                            onclick="window.print()"
                            class="bg-yellow-200 print:hidden text-yellow-900 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-yellow-300 duration-300"
                        >
                            Imprimir
                        </button>
                        <button
                            type="button"
                            @click="Open"
                            class="ml-6 bg-yellow-200 print:hidden text-yellow-900 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-yellow-300 duration-300"
                        >
                            Cancelar
                        </button>

                        <!-- <Button @click="modalOpen = true" type="button" class="bg-red-500 hover:bg-red-700 px-4 py-2 rounded-lg text-white">Registrar Pago</Button>
                            <template>
                            <modal :show="modalOpen" max-width="2xl" closeable="true" @close="close">
                                <div class="px-6 py-4">
                                    <div class="text-lg">
                                        
                                    </div>

                                    <div class="mt-4">
                                        <jet-button
                                class="ml-4 print:hidden"
                                :class="{
                                    'opacity-25': form.processing,
                                }"
                                :disabled="form.processing"
                                @click="modalOpen = false"
                            >
                                Registrar Pago
                        </jet-button>
                                    </div>
                                </div>

                                <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
                                    
                                </div>
                            </modal>
                        </template> -->
                        <jet-button
                                class="ml-4 print:hidden"
                                :class="{
                                    'opacity-25': form.processing,
                                }"
                                :disabled="form.processing"
                            >
                                Registrar Pago
                        </jet-button>
                        <a :href="route('admin.contacts.pdf', 
                                props.persona.id )"
                        target="_blank"
                        class="inline-flex print:hidden items-center ml-6 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"> Factura
                        </a>
                    </div>
                            
                            
                        </form>
                    </section>

                    
                </div>
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
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { ref, watch, defineProps } from "vue";
import DialogModal from "../../../Jetstream/DialogModal.vue";
import { useForm,Link } from "@inertiajs/vue3";

 import { defineComponent } from 'vue';
    import Modal from '@/Jetstream/Modal.vue';


const props = defineProps({
    persona: Object,
    deudas: Object,
    suma: Object,
});
const montoPagado= ref("");
/* const deudast= props.deudas; */
const sumtt=ref(0);
const modalOpen=ref(false);
const open = ref(false);
function close() {
                this.$emit('close')
        }
function Open() {
    open.value = !open.value;
}

/* function calculartt(){
    deudast.forEach(deuda => {
        sumtt=deuda.monto +sumtt;
    });
    return sumtt;
} */

const form= useForm({
    monto:"",
    fecha:"",
    persona_id:"",
    pago_id:"",
});
function storePagosBoleta() {
    form.post(`/admin/pagorecibo/${props.persona.id}/store/${montoPagado}`, 
    {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>
