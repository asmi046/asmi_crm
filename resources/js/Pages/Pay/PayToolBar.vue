<template>

    <Toolbar>
        <template #start>
            <Button @click.prevent="showAddDialog = true" icon="pi pi-plus" class="mr-2" severity="main" title="Добавить "  />
        </template>
    </Toolbar>

    <Dialog v-model:visible="showAddDialog" modal header="Добавить работу" :style="{ width: '25rem' }">
        <template #header>

        </template>

            <div class="form_body">
                <InputText v-model="addingData.name" type="text" placeholder="Работа" fluid />
                <InputText v-model="addingData.client" type="text" placeholder="Клиент" fluid />
                <DatePicker v-model="addingData.do_time" :dateFormat="'dd.mm.yy'" fluid />
                <InputNumber v-model="addingData.price" mode="currency" currency="RUB" locale="ru-RU" fluid placeholder="Цена" />
            </div>


        <template #footer>
            <Button label="Отмена" text severity="secondary" @click="visible = false" autofocus />
            <Button label="Сохранить" outlined severity="secondary" @click="createProduct" autofocus />
        </template>
    </Dialog>

</template>

<script setup>
    import { ref } from 'vue';
    let showAddDialog = ref(false)

    let addingData = ref({
        name: "",
        client:  "",
        do_time:  new Date(),
        complet:  "",
        price: 0
    })

    const createProduct = () => {
        console.log(addingData.value)
    }

</script>
