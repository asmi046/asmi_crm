<template>
    <Head>
        <title>Текущие задачи</title>
    </Head>
    <h1>Текущие задачи</h1>

    <day-works-tool-bar :clients="props.clients" v-model="selectedClient"></day-works-tool-bar>

    <div class="card">
        <DataTable  :value="props.works" editMode="cell" dataKey="id" @cell-edit-complete="onRowEditSave"
            v-model:filters="filters"
            :globalFilterFields="['client', 'state']"
        >
            <Column field="client" header="Клиент" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" fluid />
                </template>
            </Column>

            <Column field="name" header="Задача" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" fluid />
                </template>
            </Column>

            <Column field="status" header="Статус">
                <template #body="slotProps">
                    <Tag :value="slotProps.data.status" :severity="getSeverity(slotProps.data.status)" />
                </template>

                <template #editor="{ data, field }">
                    <Select v-model="data[field]" :options="statusesList" optionLabel="name" optionValue="value" placeholder="Выберите статус" />
                </template>
            </Column>

            <Column header="Управление">
                <template #body="slotProps">
                    <Button @click.prevent="deleteElement(slotProps.data)" text icon="pi pi-trash" class="mr-2" severity="danger" title="Удалить"  />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3'
    import { ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3'
    import { FilterMatchMode } from '@primevue/core/api';

    import { useConfirm } from "primevue/useconfirm";
    import { useToast } from "primevue/usetoast";
    import { useStore } from 'vuex';

    import DayWorksToolBar from '../DayWorks/DayWorksToolBar.vue';

    const toast = useToast();
    const confirm = useConfirm();

    const props = defineProps({
        works: Array,
        clients: Array
    })

    const filters = ref({
        client: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
        status: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    })

    const store = useStore()

    let selectedClient = ref(store.getters.selectedClientWork)
    filters.value.client.value = store.getters.selectedClientWork

    watch(selectedClient, (newValue, oldValue) => {
        filters.value.client.value = newValue
        store.commit('setSelectedClientWork', newValue)
    });

    watch(() => store.state.only_active_works, (newValue, oldValue) => {
        filters.value.status.value = newValue?"Активна":""
    });

    const statusesList = [
        {name: "Заверпшена", value:"Заверпшена"},
        {name: "Активна", value:"Активна"},
        {name: "Срочная", value:"Срочная"},
    ]

    const getSeverity = (product) => {
    switch (product) {
        case 'Завершена':
            return 'success';

        case 'Активна':
            return 'warn';

        case 'Срочная':
            return 'danger';

        default:
            return null;
    }
};

    const onRowEditSave = (event) => {
        let { newData, index } = event
        props.works[index] = newData

        console.log(newData)

        router.visit(route('day_work.update', newData.id), {
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
                router.visit(route('day_work.destroy', element.id), {
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

</script>
