<template>
    <Head>
        <title>Сметы</title>
    </Head>
    <h1>Сметы</h1>

    <pay-tool-bar :clients="props.clients" v-model="selectedClient"></pay-tool-bar>

    <div class="card">
        <DataTable  :value="props.pays" editMode="cell" dataKey="id" @cell-edit-complete="onRowEditSave"
            v-model:filters="filters"
            :globalFilterFields="['client']"
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

            <Column header="Управление">
                <template #body="slotProps">
                    <Button @click.prevent="deleteElement(slotProps.data)" text icon="pi pi-trash" class="mr-2" severity="danger" title="Удалить"  />
                </template>
            </Column>
            <!-- <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column> -->
        </DataTable>
    </div>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/vue3'
    import DatePicker from 'primevue/datepicker';
    import PayToolBar from '../Pay/PayToolBar.vue';
    import { ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3'

    import { FilterMatchMode } from '@primevue/core/api';

    import { useConfirm } from "primevue/useconfirm";
    import { useToast } from "primevue/usetoast";
    import { useStore } from 'vuex';

    const toast = useToast();
    const confirm = useConfirm();

    const props = defineProps({
        pays: Array,
        clients: Array
    })

    const filters = ref({
        client: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    })

    const store = useStore()

    let selectedClient = ref(store.getters.selectedClient)
    filters.value.client.value = store.getters.selectedClient

    watch(selectedClient, (newValue, oldValue) => {
        filters.value.client.value = newValue
        store.commit('setSelectedClient', newValue)
    });

    const onRowEditSave = (event) => {
        let { newData, index } = event;
        props.pays[index] = newData;

        router.visit(route('pay.update', newData.id), {
            method: 'put',
            data: newData,
            onSuccess: page => {
                toast.add({ severity: 'success', summary: "Данные сохранены", detail: "Все сохранено", life: 2000 });
            },
            onError: errors => {
                Object.keys(errors).forEach(element => {
                    toast.add({ severity: 'error', summary: "Ошибка сохранения", detail: errors[element], life: 2000 });
                });
            },
        })
    };

    const deleteElement = (element) => {
        confirm.require({
            message: 'Вы уверенны что хотите удалить запись?',
            header: 'Подтверждение удаления',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Отмена',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Удалить'
            },
            accept: () => {
                router.visit(route('pay.destroy', element.id), {
                    method: 'delete',
                    onSuccess: page => {
                        toast.add({ severity: 'success', summary: "Удаление", detail: "Все данные удалены", life: 2000 });
                    },
                    onError: errors => {
                        Object.keys(errors).forEach(element => {
                            toast.add({ severity: 'error', summary: "Ошибка сохранения", detail: errors[element], life: 2000 });
                        });
                    },
                })

            },
        });
    }

    const getDataFormat = (data) => {
        var D = new Date(data);
        return ('0' + D.getDate()).slice(-2) + '.' + ('0' + (D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear()
    }
    const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
}

</script>
