<template>
    <admin-layout title="Admin">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight container"
            >
                Usuarios ({{props.todos}})
            </h2>
        </template>
        <div class="py-2">
            <div class="container">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 justify-end">
                        <Link
                            :href="route('admin.contacts.create')"
                            class="bg-indigo-500 hover:bg-indigo-700 px-4 py-2 rounded-lg text-white"
                        >
                            Nuevo Usuario
                        </Link>
                    </div>

                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"
                    >
                        <div class="p-2 m-2">
                            <div class="flex justify-between">
                                <div class="flex-1">
                                    <div class="relative">
                                        <div
                                            class="absolute flex items-center ml-2 h-full"
                                        >
                                            <SearchIcon class="w-4 h-4" />
                                        </div>

                                        <input
                                            type="text"
                                            v-model="search"
                                            placeholder="Ingrese Nombre..."
                                            class="px-8 py-3 w-full md:w-2/6 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
                                        />
                                    </div>
                                </div>
                                <div class="flex">
                                    <select
                                        v-model="perPage"
                                        @change="getContact"
                                        class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
                                    >
                                        <option value="5">5 Per Page</option>
                                        <option value="10">10 Per Page</option>
                                        <option value="15">15 Per Page</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="w-full overflow-x-auto">
                            <Table>
                                <template #tableHead>
                                    <TableHead class="px-4 py-3"
                                        >Nombres</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Apellidos</TableHead
                                    >
                                    <TableHead class="px-4 py-3">DNI</TableHead>
                                    <TableHead class="px-4 py-3"
                                        >Direccion</TableHead
                                    >
                                    <TableHead class="px-4 py-3"
                                        >Acciones</TableHead
                                    >
                                </template>
                                <TableRow
                                    v-for="contact in contacts.data"
                                    :key="contact.id"
                                >
                                    <TableData>{{
                                        contact.first_name
                                    }}</TableData>
                                    <TableData>
                                        {{ contact.last_name }}</TableData
                                    >
                                    <TableData> {{ contact.dni }}</TableData>
                                    <TableData>
                                        {{ contact.direccion }}</TableData
                                    >

                                    <TableData>
                                        <div class="flex justify-around">
                                            <!-- <Link
                                                href="
                                                    route(
                                                        'admin.contacts.profile',
                                                        contact.id
                                                    )
                                                "
                                                class="btn btn-primary"
                                            >
                                                Perfil
                                            </Link> -->
                                            <Link
                                                :href="
                                                    route(
                                                        'admin.contacts.edit',
                                                        contact.id
                                                    )
                                                "
                                                class="bg-green-500 hover:bg-green-700 px-4 py-2 rounded-lg text-white"
                                            >
                                                Editar
                                            </Link>
                                            
                                            <Button @click="showConfirmationModal = true, objectID =contact.id, contact_name=contact.first_name " class="bg-red-500 hover:bg-red-700 px-4 py-2 rounded-lg text-white">
                                                Eliminar 
                                                
                                            </Button>
                                            <ConfirmationModalTrue 
                                                v-if="showConfirmationModal" 
                                                :message=" message+ contact_name + '?'" 
                                                @confirmed="destroyContact(objectID),showConfirmationModal = false"
                                                @canceled="showConfirmationModal = false"
                                            /> 
                                            <a :href="
                                                    route('admin.contacts.pdf', 
                                                        contact.id
                                                     )
                                                "
                                                target="_blank"
                                             class="bg-blue-500 hover:bg-blue-700 px-4 py-2 rounded-lg text-white"> Factura
                                             </a>
                                        </div>
                                    </TableData>
                                </TableRow>
                            </Table>
                        </div>
                    </div>
                </section>
                <Pagination :todo="todos" :pagination="contacts"  /> 
            </div>
        </div>
        
    </admin-layout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ConfirmationModalTrue from '@/Components/ConfirmationModalTrue.vue';
import { Link } from "@inertiajs/vue3";
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/vue3";
import { SearchIcon } from "@heroicons/vue/outline";
import Table from "../../../Components/Table.vue";
import TableData from "../../../Components/TableData.vue";
import TableHead from "../../../Components/TableHead.vue";
import TableRow from "../../../Components/TableRow.vue";
import DialogModal from "../../../Jetstream/DialogModal.vue";
import Pagination from "../../../Components/Pagination.vue";

const props = defineProps({
    contacts: Object,
    filters: Object,
    todos: Object,
});
const message= "¿Estas seguro que desear eliminar al usuario "
const search = ref(props.filters.search);
const perPage = ref("");
const showConfirmationModal = ref(false);

watch(search, (value) => {
    Inertia.get(
        "/admin/usuarios",
        { search: value, perPage: perPage.value },
        {
            preserveState: true,
            replace: true,
        }
    );
});

function destroyContact(id){
    router.delete(`/admin/usuarios/${id}/destroy`,
        { perPage: perPage.value, search: search.value },
        {
            preserveState: true,
            replace: true,
        },
        
    );
}
function getContact() {
    Inertia.get(
        "/admin/usuarios",
        { perPage: perPage.value, search: search.value },
        {
            preserveState: true,
            replace: true,
            
        }
    );
}
</script>

<style></style>
