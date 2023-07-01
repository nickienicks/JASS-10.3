<template >
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
                                            v-model="monto_predef"
                                            
                                            autofocus
                                            autocomplete="monto"
                                            
                                        />

                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.monto"
                                        >
                                            {{ form.errors.monto }}
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
                                        Registrar Corte
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
    
});
const monto_predef=ref(30);

const form = useForm({
    fecha: "",
    monto: monto_predef,
    medida_ant:0,
    medida_act: 0,
    type:2,
    persona_id: props.persona.id,
});

const vari = ref(30);


function storeDeuda() {
    form.post(`/admin/deudas/${props.persona.id}/corte-manual/store`);
}
</script>
<style >
    
</style>