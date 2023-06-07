<template>
    <admin-layout title="Admin">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Asignar Deuda
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
                            <form @submit.prevent="storeDeuda">
                                <div class="grid grid-cols-2 gap-8 p-4">
                                    <div>
                                        <jet-label for="fecha" value="Fecha" />
                                        <jet-input
                                            id="fecha"
                                            type="date"
                                            class="mt-1 block w-full"
                                            v-model="form.fecha"
                                            autofocus
                                            autocomplete="fecha"
                                        />
                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.fecha"
                                        >
                                            {{ form.errors.fecha }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label for="monto" value="Monto" />
                                        <jet-input
                                            id="monto"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="calcularMonto"
                                            autofocus
                                            autocomplete="monto"
                                            placeholder="monto de deuda..."
                                        />

                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.monto"
                                        >
                                            {{ form.errors.monto }}
                                        </div>
                                    </div>

                                    <div class="">
                                        <jet-label
                                            for="medida_ant"
                                            value="medida_ant"
                                        />
                                        <jet-input
                                            id="medida_ant"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.medida_ant"
                                            autofocus
                                            autocomplete="medida_ant"
                                            placeholder="medidada anterior..."
                                        />
                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.medida_ant"
                                        >
                                            {{ form.errors.medida_ant }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label
                                            for="medida_act"
                                            value="Medida_act"
                                        />
                                        <jet-input
                                            id="medida_act"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.medida_act"
                                            autofocus
                                            autocomplete="medida_act"
                                            placeholder="medida Actual..."
                                        />

                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.medida_act"
                                        >
                                            {{ form.errors.medida_act }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-input
                                            id="persona_id"
                                            type="text"
                                            class="mt-1 w-full hidden"
                                            autofocus
                                            v-model="form.persona_id"
                                            autocomplete="persona_id"
                                        />
                                    </div>
                                </div>

                                <div class="flex items-center justify-end m-4">
                                    <jet-button
                                        class="ml-4"
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                    >
                                        Registrar Deuda
                                    </jet-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
       
    </admin-layout>
</template>

<script setup>
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
    deudas: Object,
    final: Object,
});
const mediant=ref(props.final);
const form = useForm({
    fecha: "",
    monto: "",
    medida_ant: props.final !== null ? props.final.medida_act : 0 ,
    medida_act: "",
    persona_id: props.persona.id,
});
const vari = ref(30);
const calcularMonto = computed(() => {
    let montoTotal;
    let montoResta ;
    
    try {
        let resta = parseInt(form.medida_act) - parseInt(form.medida_ant);
        if (resta <= 7) {
            montoTotal = 14;
        } else {
            if (resta > 20) {
                montoTotal = ((resta-7) * 3 )+14;
            } else {
                montoTotal = resta * 2;
            }
        } 
        if(isNaN(montoTotal)){
            parseFloat(montoTotal);
        }else{ 
            form.monto = montoTotal;
            return montoTotal;
         } 
    } catch (error) {
        console.log(error);
       
    }
});
// const montoCalculado = ref(parseInt(calcularMonto));
function storeDeuda() {
    form.post(`/admin/deudas/${props.persona.id}/store`, {
        preserveScroll: true,
        onSuccess:()=>{
            form.reset('fecha','monto','medida_act','medida_ant');
            form.medida_ant = props.final.medida_act; 
            },
    });
}
</script>

<style></style>
