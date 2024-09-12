<template>
    <Toast />
    <slot></slot>
</template>

<script setup>
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
const toast = useToast();
</script>
