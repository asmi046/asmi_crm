<template>
    <Head>
        <title>Главная</title>
    </Head>
    <div class="card">
        <DataTable :value="props.worcprice" tableStyle="min-width: 50rem">
            <Column field="client" header="Клиент"></Column>
            <Column field="count" header="Выполнено работ"></Column>
            <Column field="summ" header="Сумма">
                <template #body="{ data, field }">
                    {{ formatCurrency(data[field]) }}
                </template>
            </Column>
        </DataTable>
    </div>
    <p>
        Итого: <strong>{{ formatCurrency(props.total) }}</strong>
    </p>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'

const props = defineProps({
    worcprice: Array,
    total: Number
})

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
}

</script>
