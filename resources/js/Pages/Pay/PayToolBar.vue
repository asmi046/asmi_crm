<template>

    <Toolbar>
        <template #start>
            <div class="tolbar_wrapper">
                <Button @click.prevent="showAddDialog = true" icon="pi pi-plus" class="mr-2" severity="main" title="Добавить "  />
                <Select v-model="selectedElement" :options="clientList" optionLabel="label" optionValue="value" placeholder="Выберите клиента" @change="selectClient" class="element" />
                <Button @click.prevent="massPayCheck" :disabled="selected == undefined || selected.length == 0" icon="pi pi-money-bill" class="ml" severity="main" title="Проставить статус оплачено"  />
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
    import { useConfirm } from "primevue/useconfirm";

    const toast = useToast();
    const confirm = useConfirm();

    const props = defineProps({
        clients: Array
    })

    const model = defineModel()
    const selected = defineModel('selected')

    console.log(model.value)
    console.log(selected.value)


    watch(selected, (newValue, oldValue) => {
        console.log(newValue)
    });

    let selectedElement = ref(model.value)
    const emit = defineEmits(['update:modelValue'])

    let clientList = ref([])

    clientList.value.push({label:"Все клиенты", value:""})
    for ( let element in props.clients) {
        clientList.value.push({label:props.clients[element].client, value:props.clients[element].client})
    }


    let showAddDialog = ref(false)
    let selectedCa = ref("")

    let addingData = ref({
        name: "",
        client:  model.value,
        do_time: new Date(),
        complet:  false,
        price: 0
    })


    const massPayCheck = () => {
        console.log(111)
        confirm.require({
            message: 'Вы действительно хотите пометить эти работы как оплаченные?',
            header: 'Подтверждение',
            icon: 'pi pi-info-circle',
            rejectProps: {
                label: 'Отмена',
                severity: 'secondary',
                text: true
            },
            acceptProps: {
                label: 'Пометить',
                text: true
            },
            accept: () => {
                let ids = []
                for (let element in selected.value) {
                    ids.push(selected.value[element].id)
                }

                router.visit(route('pay_msaa_check'), {
                    method: 'patch',
                    data: {'ids': ids},
                    onSuccess: page => {
                        console.log(page.props.count)
                        toast.add({ severity: 'success', summary: "Данные обновлены: ", detail: "Все сохранено", life: 2000 });
                    },
                    onError: errors => {
                        Object.keys(errors).forEach(element => {
                            toast.add({ severity: 'error', summary: "Ошибка обновления", detail: errors[element], life: 2000 });
                        });
                    },
                })
            },
            reject: () => {

            }
        });
    }

    const selectClient = (element) => {
        addingData.value.client = element.value
        emit('update:modelValue', element.value)
    }


    const createProduct = () => {


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
