<template>
    <Head>
        <title>Сметы</title>
    </Head>
    <h1>Сметы</h1>

    <pay-tool-bar></pay-tool-bar>

    <div class="card">
        <DataTable v-model:editingRows="editingRows" :value="props.pays" editMode="row" dataKey="id" @row-edit-save="onRowEditSave"

        >
            <Column field="client" header="Клиент" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" fluid />
                </template>
            </Column>

            <Column field="name" header="Работа" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" fluid />
                </template>
            </Column>

            <Column field="do_time" header="Дата выполнения" style="width: 20%">
                <template #editor="{ data, field }">
                    <DatePicker v-model="data[field]" :dateFormat="'dd.mm.yy'" />
                </template>
                <template #body="slotProps">
                    {{ getDataFormat(slotProps.data.do_time) }}
                </template>
            </Column>
            <Column field="price" header="Цена" style="width: 20%">
                <template #body="{ data, field }">
                    {{ formatCurrency(data[field]) }}
                </template>
                <template #editor="{ data, field }">
                    <InputNumber v-model="data[field]" mode="currency" currency="RUB" locale="ru-RU" fluid />
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
        </DataTable>
    </div>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/vue3'
    import DatePicker from 'primevue/datepicker';
    import PayToolBar from '../Pay/PayToolBar.vue';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3'

    import { useToast } from "primevue/usetoast";

    const toast = useToast();

    const props = defineProps({
        pays: Array
    })

    const editingRows = ref([]);

    const onRowEditSave = (event) => {
        let { newData, index } = event;
        props.pays[index] = newData;

        router.visit(route('pay.update', newData.id), {
            method: 'put',
            data: newData,
            onSuccess: page => {
                console.log("Да");
            },
            onError: errors => {
                Object.keys(errors).forEach(element => {
                    toast.add({ severity: 'error', summary: "Ошибка сохранения", detail: errors[element], life: 2000 });
                });
            },
        })
    };

    const getDataFormat = (data) => {
        var D = new Date(data);
        return ('0' + D.getDate()).slice(-2) + '.' + ('0' + (D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear()
    }
    const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
}

</script>
