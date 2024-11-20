<template>
    <Toolbar>
        <template #start>
            <Button @click.prevent="showAddDialog = true" icon="pi pi-plus" class="mr-2" severity="main" title="Добавить сайт"  />
        </template>
    </Toolbar>

    <Dialog v-model:visible="showAddDialog" modal header="Добавить сайт" :style="{ width: '25rem' }">
        <template #header>

        </template>

            <div class="form_body">
                <InputText v-model="addingData.name" type="text" placeholder="Название" fluid />
                <InputText v-model="addingData.site" type="text" placeholder="Адрес сайта" fluid />

            </div>


        <template #footer>
            <Button label="Отмена" text severity="secondary" @click="showAddDialog = false" autofocus />
            <Button label="Сохранить" outlined severity="secondary" @click.prevent="createSite" autofocus />
        </template>
    </Dialog>

</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'

import { useToast } from "primevue/usetoast";
const toast = useToast();

let showAddDialog = ref(false)

let addingData = ref({
        name: "",
        site:  "",
        description: ""
})

    const createSite = () => {
        console.log(addingData.value)
        router.visit(route('site.store'), {
            method: 'post',
            data: addingData.value,
            onSuccess: page => {
                toast.add({ severity: 'success', summary: "Данные сохранены", detail: "Сайт добавлен", life: 2000 });
            },
            onError: errors => {
                Object.keys(errors).forEach(element => {
                    toast.add({ severity: 'error', summary: "Ошибка сохранения", detail: errors[element], life: 2000 });
                });
            },
        })
    }

</script>
