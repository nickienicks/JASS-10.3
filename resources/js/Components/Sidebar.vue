<template>
    <div
        :class="sidebarOpen ? 'block' : 'hidden'"
        @click="sidebarOpen = !false"
        class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"
    ></div>

    <div
        :class="
            sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'
        "
        class="fixed z-30 inset-y-0 left-0 w-60 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0"
    >
        <div class="flex items-center justify-center mt-8">
            <div class="flex items-center">
                <svg
                    class="h-12 w-12"
                    viewBox="0 0 512 512"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z"
                        fill="#4C51BF"
                        stroke="#4C51BF"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z"
                        fill="white"
                    />
                </svg>

                <span class="text-white text-2xl mx-2 font-semibold"
                    >JASS</span
                >
            </div>
        </div>

        <nav class="mt-10">
            <!-- <Prueba
                :href="route('admin.home')"
                label="gaaaa"
                :active="route().current('admin.home')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba> -->
            <Prueba
                :href="route('admin.contacts.index')"
                label="Usuarios"
                :active="route().current('admin.contacts.*')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba>
            <Prueba
                :href="route('admin.deudas.index')"
                label="Deudas"
                :active="route().current('admin.deudas.*')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba>
            <Prueba
                :href="route('admin.pagos.index')"
                label="Pagos"
                :active="route().current('admin.pagos.*')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba>
            <Prueba
                :href="route('admin.historiales.index')"
                label="Historial"
                :active="route().current('admin.historiales.*')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba>
            <!-- <Prueba
                :href="route('admin.ingresos.index')"
                label="Ingresos"
                :active="route().current('admin.ingresos.*')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba> -->
            <Prueba
                :href="route('admin.cortes.index')"
                label="Cortes"
                :active="route().current('admin.cortes.*')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba>
            <Prueba
                :href="route('admin.imprimir.index')"
                label="Imprimir Facturas"
                :active="route().current('admin.imprimir.*')"
            >
                <template #logo>
                    <DatabaseIcon class="h-6 w-6" />
                </template>
            </Prueba>
            
            <div class=" w-full">
                <button class="absolute bottom-0 w-full  flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-500 hover:bg-opacity-25 hover:text-gray-100" @click="modalOpen =true ">
                <DatabaseIcon class="h-6 w-6" />Cerrar  </button>
            </div>
           
            
            <DialogModal :show="modalOpen">
                <template v-slot:title>
                    <h1>Cerrar sesión</h1>
                </template>
                <template v-slot:content>
                    <p>¿Seguro que deseas cerrar sesión?</p>
                </template>
                <template v-slot:footer>
                    <button @click="modalOpen=false" class="bg-blue-500 mr-4 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-blue-300">
                        Cancelar
                    </button> 
                     <button >
                     <Link href="/logout" method="post" class="bg-red-500 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-red-300">Cerrar Sesión</Link>
                        
                    </button>   
                </template>

            </DialogModal>
            
               
        </nav>
    </div>
</template>

<script setup>
import Prueba from "../Components/Prueba.vue";
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import DialogModal from "../Jetstream/DialogModal.vue";
import Button from "../Jetstream/Button.vue";

import { Link } from "@inertiajs/vue3";

import { ref } from "vue";
import {
    DatabaseIcon,
    FingerPrintIcon,
    UserGroupIcon,
    LockClosedIcon,
    LibraryIcon,
    PuzzleIcon,
} from "@heroicons/vue/outline";

const modalOpen= ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};

const dialogout=()=>{
    
};
const sidebarOpen = ref(false);
</script>

<style></style>
