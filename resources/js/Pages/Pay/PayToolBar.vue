<template>

    <Toolbar>
        <template #start>
            <div class="tolbar_wrapper">
                <Button @click.prevent="showAddDialog = true" icon="pi pi-plus" class="mr-2" severity="main" title="Добавить "  />
                <Select v-model="selectedElement" :options="clientList" optionLabel="label" optionValue="value" placeholder="Выберите клиента" @change="selectClient" class="element" />
            </div>
        </template>
    </Toolbar>

    <Dialog v-model:visible="showAddDialog" modal header="Добавить работу" :style="{ width: '25rem' }">
        <template #header>

        </template>

            <div class="form_body">
                <InputText v-model="addingData.client" type="text" placeholder="Клиент" fluid />
                <DatePicker v-model="addingData.do_time" :dateFormat="'dd.mm.yy'" fluid />
                <InputText v-model="addingData.name" type="text" placeholder="Работа" fluid />
                <InputNumber v-model="addingData.price" mode="currency" currency="RUB" locale="ru-RU" fluid placeholder="Цена" />
            </div>


        <template #footer>
            <Button label="Отмена" text severity="secondary" @click="showAddDialog = false" autofocus />
            <Button label="Сохранить" outlined severity="secondary" @click.prevent="createProduct" autofocus />
        </template>
    </Dialog>

</template>

<script setup>
    import { ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3'

    import { useToast } from "primevue/usetoast";
    const toast = useToast();

    const props = defineProps({
        clients: Array,
        modelValue: String
    })

    let selectedElement = ref(props.modelValue)
    const emit = defineEmits(['update:modelValue'])

    let clientList = ref([])

    for ( let element in props.clients) {
        clientList.value.push({label:props.clients[element].client, value:props.clients[element].client})
    }


    let showAddDialog = ref(false)
    let selectedCa = ref("")

    let addingData = ref({
        name: "",
        client:  props.modelValue,
        do_time: new Date(),
        complet:  false,
        price: 0
    })


    const selectClient = (element) => {
        addingData.value.client = element.value
        emit('update:modelValue', element.value)
    }


    const createProduct = () => {
        console.log(addingData.value)
        router.visit(route('pay.store'), {
            method: 'post',
            data: addingData.value,
            onSuccess: page => {
                toast.add({ severity: 'success', summary: "Данные сохранены", detail: "Все сохранено", life: 2000 });
            },
            onError: errors => {
                Object.keys(errors).forEach(element => {
                    toast.add({ severity: 'error', summary: "Ошибка сохранения", detail: errors[element], life: 2000 });
                });
            },
        })
    }

</script>
