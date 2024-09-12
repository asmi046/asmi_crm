<template>
<Head>
    <title>Сайты</title>
</Head>

<h1>Сайты</h1>

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
    import { Head } from '@inertiajs/vue3'
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import Drawer from 'primevue/drawer';
    import Button from 'primevue/button';
    import EditorHtml from '../../Components/EditorHtml.vue';
    import { FilterMatchMode } from '@primevue/core/api';
    import InputText from 'primevue/inputtext';

    import { ref } from 'vue';

    const filters = ref({
        name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    })

    let drawerVisible = ref(false)
    let drawerName = ref('Старт')
    let drawerDescription = ref('Старт!!!!!')

    const showDescription = (item) => {
        drawerName.value = item.name
        drawerDescription.value = item.description
        drawerVisible.value = true
    }

    const props = defineProps({
        sites: Array
    })

</script>
