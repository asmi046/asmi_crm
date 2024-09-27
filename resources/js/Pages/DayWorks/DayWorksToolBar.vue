<template>

    <Toolbar>
        <template #end>
            <ToggleSwitch v-model="onlyActive" /> <p class="ml">Только активные</p>
        </template>

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
                <InputText v-model="addingData.name" type="text" placeholder="Работа" fluid />
            </div>


        <template #footer>
            <Button label="Отмена" text severity="secondary" @click="showAddDialog = false" autofocus />
            <Button label="Сохранить" outlined severity="secondary" @click.prevent="createWork" autofocus />
        </template>
    </Dialog>

</template>

<script setup>
    import { ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3'

    import { useToast } from "primevue/usetoast";
    import { useStore } from 'vuex';

    const toast = useToast()
    const store = useStore()

    const props = defineProps({
        clients: Array,
        modelValue: String
    })

    let onlyActive = ref((store.getters.onlyActiveWorks === "true"))
    console.log(onlyActive.value)

    let selectedElement = ref(props.modelValue)
    const emit = defineEmits(['update:modelValue'])

    let clientList = ref([])

    clientList.value.push({label:"Все клиенты", value:""})
    for ( let element in props.clients) {
        clientList.value.push({label:props.clients[element].client, value:props.clients[element].client})
    }

    watch(onlyActive, (newValue) => {
        console.log(onlyActive.value)
        store.commit('setOnlyActiveWorks', newValue)
    })

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


    const createWork = () => {
        router.visit(route('day_work.store'), {
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
