<template>
    <div
        :class="classes"
        class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-500 hover:bg-opacity-25 hover:text-gray-100"
    >
        <slot name="logo" />
        <Link class="ml-3" :href="href">{{ label }} </Link>
    </div>
</template>
<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Link,
    },
    props: ["href", "active", "label"],

    computed: {
        classes() {
            return this.active ? "bg-gray-500 bg-opacity-25 text-gray-100" : "";
        },
    },
});
</script>

<style></style>
