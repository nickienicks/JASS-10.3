<template>
    <admin-layout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Confirma el pago porfavor
            </h2>
        </template>
        <div class="">
            <form @submit.prevent="updateDeudas">
                <div>
                    <jet-input
                        id="fecha"
                        type="date"
                        class="hidden mt-1 w-full"
                        v-model="formUpdate.fecha"
                        autofocus
                        autocomplete="fecha"
                    />
                </div>
                <div class="">
                    <jet-input
                        id="medida_ant"
                        type="text"
                        class="hidden mt-1 w-full"
                        v-model="formUpdate.medida_ant"
                        autofocus
                        autocomplete="medida_ant"
                        placeholder="medidada anterior..."
                    />
                </div>
                <div class="">
                    <jet-input
                        id="medida_act"
                        type="text"
                        class="hidden mt-1 w-full"
                        v-model="formUpdate.medida_act"
                        autofocus
                        autocomplete="medida_act"
                        placeholder="medida Actual..."
                    />
                </div>
                <div class="">
                    <jet-input
                        id="persona_id"
                        type="text"
                        class="hidden mt-1 w-full"
                        autofocus
                        v-model="formUpdate.persona_id"
                        autocomplete="persona_id"
                    />
                </div>

                <div class="">
                    <jet-input
                        id="monto"
                        type="text"
                        class="mt-1 w-full hidden"
                        autofocus
                        v-model="formUpdate.monto"
                        autocomplete="monto"
                    />
                </div>
                <div class="flex items-center justify-star m-4">
                    <div>
                        <Link
                            :href="
                                route('admin.pagos.view', [
                                    persona.id,
                                    deuda.id,
                                ])
                            "
                            class="bg-green-500 hover:bg-green-700 px-4 py-2 rounded-lg text-white"
                        >
                            Regresar
                        </Link>
                        <button 
                            class="bg-blue-500 
                            hover:bg-blue-700 px-4 py-2 
                            rounded-lg text-white mx-4" 
                            @click="updateDeudas"> 
                            Confirmar Pago 
                        </button>
                        
                        <a
                            class="bg-amber-500 hover:bg-amber-700 px-4 py-2 rounded-lg text-white"
                            :href="
                                route('admin.pagos.pdf', [
                                    persona.id
                                ])
                            "
                            target="_blank"
                        >
                            Generar Boleta
                        </a>
                        
                    </div>
                </div>
            </form>
        </div>
    </admin-layout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref, watch, defineProps } from "vue";
import { router} from "@inertiajs/vue3";
import { SearchIcon } from "@heroicons/vue/outline";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { useForm, Link } from "@inertiajs/vue3";
const props = defineProps({
    persona: Object,
    deuda: Object,
    pago: Object,
});
const total = ref(props.deuda.monto - props.pago.monto);
if (total.value < 0) {
    total.value = 0;
}
const formUpdate = useForm({
    fecha: props.deuda.fecha,
    monto: total.value,
    medida_ant: props.deuda.medida_ant,
    medida_act: props.deuda.medida_ant,
    persona_id: props.persona.id,
});
function updateDeudas() {
    router.post(
        `/admin/pagos/ ${props.persona.id}/update/${props.deuda.id}`,
        {
            _method: "put",
            fecha: formUpdate.fecha,
            monto: formUpdate.monto,
            medida_ant: formUpdate.medida_ant,
            medida_act: formUpdate.medida_act,
            persona_id: formUpdate.persona_id,
        }
    );
}
</script>

<style></style>