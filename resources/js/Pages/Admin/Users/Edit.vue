<template>
    <admin-layout title="Admin">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                EDITAR USUARIO
            </h2>
        </template>

        <div class="py-2">
            <div class="container">
                <section class="container mx-auto p-6 font-mono">
                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="w-full overflow-x-auto">
                            <form @submit.prevent="updateUser">
                                <div class="grid grid-cols-2 gap-8 p-4">
                                    <div>
                                        <jet-label
                                            for="firstname"
                                            value="Nombres"
                                        />
                                        <jet-input
                                            id="firstname"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.firstname"
                                            autofocus
                                            autocomplete="firstname"
                                            placeholder="nombres de usuario..."
                                        />
                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.firstname"
                                        >
                                            {{ form.errors.firstname }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label
                                            for="lastname"
                                            value="Apellidos"
                                        />
                                        <jet-input
                                            id="lastname"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.lastname"
                                            autofocus
                                            autocomplete="lastname"
                                            placeholder="apellidos de usuario..."
                                        />

                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.lastname"
                                        >
                                            {{ form.errors.lastname }}
                                        </div>
                                    </div>

                                    <div class="">
                                        <jet-label for="dni" value="DNI" />
                                        <jet-input
                                            id="dni"
                                            type="text"
                                            maxlength="8"
                                            class="mt-1 block w-full"
                                            v-model="form.dni"
                                            autofocus
                                            autocomplete="dni"
                                            placeholder="DNI de usuario..."
                                        />

                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.dni"
                                        >
                                            {{ form.errors.dni }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label
                                            for="direccion"
                                            value="Direccion"
                                        />
                                        <jet-input
                                            id="direccion"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.direccion"
                                            autofocus
                                            autocomplete="direccion"
                                            placeholder="Direccion de usuario..."
                                        />

                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.direccion"
                                        >
                                            {{ form.errors.direccion }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label
                                            for="zona"
                                            value="Zona"
                                        />
                                        <select 
                                            class=" mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                            id="zona"
                                            type="text"
                                            
                                            v-model="form.zona"
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

                                        <div
                                            class="text-sm text-red-400"
                                            v-if="form.errors.zona"
                                        >
                                            {{ form.errors.zona }}
                                        </div>
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
                                        Actualizar
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
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { SearchIcon } from "@heroicons/vue/outline";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { useForm, Link } from "@inertiajs/vue3";

const props = defineProps({
    persona: Object,
    image: String,
});

const form = useForm({
    firstname: props.persona.first_name,
    lastname: props.persona.last_name,
    dni: props.persona.dni,
    direccion: props.persona.direccion,
    zona: props.persona.zona,
});

function updateUser() {
    form.put(`/admin/usuarios/ ${props.persona.id}`);
}
</script>

<style></style>
