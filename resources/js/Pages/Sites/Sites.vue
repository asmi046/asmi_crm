<template>
<Head>
    <title>Сайты</title>
</Head>

<h1>Сайты</h1>

<sites-tool-bar></sites-tool-bar>

<Dialog v-model:visible="showAddDialog" modal header="Edit Profile" :style="{ width: '25rem' }">
    <template #header>
    </template>

    <template #footer>
        <Button label="Cancel" text severity="secondary" @click="visible = false" autofocus />
        <Button label="Save" outlined severity="secondary" @click="visible = false" autofocus />
    </template>
</Dialog>

<br>
<DataTable :value="props.sites" paginator :rows="20" filterDisplay="row" v-model:filters="filters" :globalFilterFields="['name']" tableStyle="min-width: 50rem">
    <Column field="name" header="Имя">
        <template #body="{ data }">
                    {{ data.name }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText :fluid="true" v-model="filterModel.value" type="text" @input="filterCallback()" placeholder="Поиск по имени" />
                </template>
    </Column>
    <Column header="Управление">
        <template #body="slotProps">
            <Button icon="pi pi-arrow-right" @click="showDescription(slotProps.data)" />
        </template>
    </Column>
</DataTable>

<div class="card flex justify-center">
        <Drawer v-model:visible="drawerVisible" :header="drawerName">
            <editor-html v-model="drawerDescription" ></editor-html>
        </Drawer>
</div>



</template>

<script setup>
    import { Head, useForm } from '@inertiajs/vue3'
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import Drawer from 'primevue/drawer';
    import Button from 'primevue/button';
    import SitesToolBar from './SitesToolBar.vue';
    import EditorHtml from '../../Components/EditorHtml.vue';
    import { FilterMatchMode } from '@primevue/core/api';
    import InputText from 'primevue/inputtext';
    import edjsHTML from 'editorjs-html'

    import { useToast } from "primevue/usetoast";
    const toast = useToast();

    import { ref, watch } from 'vue';

    const filters = ref({
        name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    })

    let showAddDialog = ref(false)

    let drawerVisible = ref(false)
    let drawerName = ref('Старт')
    let drawerDescription = ref('Старт!!!!!')
    let editedItem = ref(-1)

    const showDescription = (item) => {
        editedItem.value = item;
        drawerName.value = item.name
        drawerDescription.value = item.description
        drawerVisible.value = true
    }

    const props = defineProps({
        sites: Array
    })

    const updateField = () => {
        if (typeof drawerDescription.value == 'string') return
        const edjsParser = edjsHTML();
        let html = edjsParser.parse(drawerDescription.value);

        let htmlStr = ""
        for (let i=0; i<html.length; i++)
            htmlStr+=html[i]

        const form = useForm({
            name: drawerName.value,
            description: htmlStr
        })

        form.put(route('site.update', editedItem.value.id), {
            onError: (errors) => {

                Object.keys(errors).forEach(element => {
                    toast.add({ severity: 'error', summary: "Ошибка авторизации", detail: errors[element], life: 5000 });
                });
            },
        })
    }

    watch(drawerDescription, async (newQuestion, oldQuestion) => {
        updateField()
    })

</script>
