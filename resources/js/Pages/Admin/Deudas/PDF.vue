<template>
    <div>pdf {{ pdf }}</div>
</template>

<script setup>
import { ref, watch, defineProps } from "vue";
const props = defineProps({
    pdf: String,
});
</script>

<style></style>
