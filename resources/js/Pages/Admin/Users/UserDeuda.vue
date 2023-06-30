<template>
    <admin-layout title="Admin">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight container">
                Nuevo Usuario
            </h2>
        </template>

        <div class="py-2">
            <div class="container">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            
                                <div class="grid grid-cols-2 gap-5 p-4">
                                    <div>
                                        <h2 class=" text-xl font-extrabold dark:text-black" >Nombre:</h2>
                                        <a> {{ persona.first_name }}</a>
                                    </div>
                                    <div class="">
                                        <h2 class=" text-xl font-extrabold dark:text-black" >Apellidos:</h2>
                                        <a> {{ persona.last_name }}</a>
                                        
                                    </div>

                                    <div class="">
                                        <h2 class=" text-xl font-extrabold dark:text-black" >DNI:</h2>
                                        <a> {{ persona.dni }}</a>
                                    </div>
                                    <div class="">
                                        <h2 class=" text-xl font-extrabold dark:text-black" >Dirección:</h2>
                                        <a> {{ persona.direccion }}</a>
                                    </div>
                                    <div class="">
                                        <h2 class=" text-xl font-extrabold dark:text-black" >Zona:</h2>
                                        <a> {{ persona.zona }}</a>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Asignar Deuda</h1>
                    </div>
                    <div class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">

                            <form @submit.prevent=" submitForm">
                                <div class="grid grid-cols-2 gap-8 p-4">
                                    <div class="">
                                        <jet-label for="fecha" value="Fecha" />
                                        <jet-input id="fecha" type="date" class="mt-1 block w-full" v-model="form.fecha"
                                            autofocus autocomplete="fecha" />
                                        <div class="text-sm text-red-400" v-if="form.errors.fecha">
                                            {{ form.errors.fecha }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label for="monto" value="Monto" />
                                        <jet-input id="monto" type="text" class="mt-1 block w-full" v-model="calcularMonto"
                                            autofocus autocomplete="monto" placeholder="monto de deuda..." />

                                        <div class="text-sm text-red-400" v-if="form.errors.monto">
                                            {{ form.errors.monto }}
                                        </div>
                                    </div>

                                    <div class="">
                                        <jet-label for="medida_ant" value="medida_ant" />

                                        <jet-input id="medida_ant" type="text" class="mt-1 block w-full"
                                            v-model="form.medida_ant" autofocus autocomplete="medida_ant"
                                            placeholder="medidada anterior..." />
                                        <div class="text-sm text-red-400" v-if="form.errors.medida_ant">
                                            {{ form.errors.medida_ant }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label for="medida_act" value="Medida_act" />
                                        <jet-input id="medida_act" type="text" class="mt-1 block w-full"
                                            v-model="form.medida_act" autofocus autocomplete="medida_act"
                                            placeholder="medida Actual..." />

                                        <div class="text-sm text-red-400" v-if="form.errors.medida_act">
                                            {{ form.errors.medida_act }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-input id="persona_id" type="text" class="mt-1 w-full hidden" autofocus
                                            v-model="form.persona_id" autocomplete="persona_id" />
                                    </div>
                                </div>
                                <!-- <jet-button
                                        class="ml-4"
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                        @click="showConfirmationModal = true"
                                         @click.="showConfirmationModal = canShowConfirmationModal()"
                                    > -->

                                <div class="flex items-center justify-end m-4">
                                    <button  @click="showConfirmationModal = canShowConfirmationModal()">
                                        Registrar Deuda
                                    </button>
                                </div>

                            </form>
                            <ConfirmationModalTrue 
                                v-if="showConfirmationModal" 
                                :message="message" 
                                @confirmed="confirm"
                                @canceled="showConfirmationModal = false" />
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div>

        </div>

    </admin-layout>
</template>

<script setup>
import ConfirmationModalTrue from '@/Components/ConfirmationModalTrue.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref, watch, defineProps, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { SearchIcon } from "@heroicons/vue/outline";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { useForm, Link } from "@inertiajs/vue3";

const props = defineProps({
    persona: Object,
    deudass: Object,
});

const aShowConfirmationModal= ref(true);
const message = '¿Estás seguro de que quieres registrar esta deuda?';
const showConfirmationModal = ref(false);
const mconfirm = ref(false);


const form = useForm({
    firstname: props.persona.first_name,
    lastname: props.persona.last_name,
    dni: props.persona.dni,
    direction: props.persona.direccion,
    medidor_id: props.persona.zona,
    fecha: "",
    monto: "",
    medida_ant: "",
    medida_act: "",
    persona_id: props.persona.id,
});

function canShowConfirmationModal() {
    
    if (!form.fecha || !form.monto || !form.medida_act || !form.medida_ant) {
        
        return false;
    }
    
    return true;
  
};
function confirm() {
    
    storeDeuda();
    
}
function cancel() {
    showConfirmationModal.value = false;
}
var calcularMonto = computed(() => {
    let montoTotal = 0;
    let montoResta = 0;
    let resta1=0;
    try {
        let resta = parseInt(form.medida_act) - parseInt(form.medida_ant);          
        if (resta <= 20) {
            montoTotal = resta * 2;
        } else {
            resta1 = resta - 20;
            montoTotal = ((resta1*3) + 40);
            
        }
        if (isNaN(montoTotal)) {
            parseFloat(montoTotal);
            
        } else {
            form.monto = montoTotal;
            return montoTotal;
        }
    } catch (error) {
        console.log(error);
    }
});

function submitForm() {   
    if (canShowConfirmationModal()) {
    showConfirmationModal.value = true;
  } else {
    storeDeuda();
  }
   
}

function storeDeuda() {
    
    form.post(`/admin/usuarios/${props.persona.id}/storedeudas`, 
        {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('fecha', 'monto', 'medida_act', 'medida_ant');
                form.medida_ant = props.deudass.medida_act;
                showConfirmationModal.value = false;
            },
        }
    );   
}
</script>

<style></style>