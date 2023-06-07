<template>
    <admin-layout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Realizar un pago
            </h2>
        </template>

        <div class="py-2">
            <div class="container">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-auto mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="w-auto overflow-x-auto p-4">
                            <div class="grid grid-cols-2 gap-8 p-2 mb-4">
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
                            <div class="grid grid-cols-2 gap-8 p-2 mb-4">
                                <form @submit.prevent="storePagos">
                                    <div
                                        class="grid grid-cols-2 p-2 mb-4 items-center"
                                    >
                                        <jet-label
                                            for="fecha"
                                            value="Fecha de pago"
                                        />
                                        <jet-input
                                            id="fecha"
                                            type="date"
                                            class="mt-1 w-full block"
                                            v-model="form.fecha"
                                            disabled
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
                                    <div
                                        class="grid grid-cols-2 p-2 mb-4 items-center"
                                    >
                                        <jet-label for="monto" value="Deuda" />

                                        <p class="mt-1 ml-3 block w-full">
                                            {{ deuda.monto }}
                                        </p>
                                    </div>
                                    <div
                                        class="grid grid-cols-2 p-2 mb-4 items-center"
                                    >
                                        <jet-label
                                            for="monto"
                                            value="Monto de pago"
                                        />
                                        <jet-input
                                            id="pago"
                                            type="text"
                                            class="mt-1 block"
                                            v-model="form.monto"
                                            autofocus
                                            autocomplete="monto"
                                            placeholder="monto de pago..."
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

                                    <div class="">
                                        <jet-input
                                            id="deuda_id"
                                            type="text"
                                            class="mt-1 w-full hidden"
                                            autofocus
                                            v-model="form.deuda_id"
                                            autocomplete="deuda_id"
                                        />
                                    </div>

                                    <div
                                        class="flex items-center justify-end m-4"
                                    >
                                        <jet-button
                                            class="ml-4"
                                            :class="{
                                                'opacity-25': form.processing,
                                            }"
                                            :disabled="form.processing"
                                        >
                                            Registrar Pago
                                        </jet-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </admin-layout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/vue3";
import { SearchIcon } from "@heroicons/vue/outline";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { useForm, Link } from "@inertiajs/vue3";
const props = defineProps({
    persona: Object,
    deuda: Object,
    now: Object,
});

const form = useForm({
    fecha: props.now,
    monto: "",
    persona_id: props.persona.id,
    deuda_id: props.deuda.id,
});

const total = ref(props.deuda.monto - parseInt(form.monto));

function storePagos() {
    form.post(`/admin/pagos/${props.persona.id}/store/${props.deuda.id}`, {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>
