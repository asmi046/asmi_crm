<template>
    <Toast />
    <ConfirmDialog></ConfirmDialog>
    <main-menue></main-menue>
    <section>
        <div class="_container">
            <slot></slot>
        </div>
    </section>

</template>

<script setup>
    import Toast from 'primevue/toast';
    import { useToast } from "primevue/usetoast";
    const toast = useToast();
    import MainMenue from '../Components/MainMenue.vue';
</script>
