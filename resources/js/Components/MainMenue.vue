<template>
    <section>
        <div class="_container">
            <Menubar :model="items" >
                <template #item="{ item, props, hasSubmenu  }">

                    <Link :class="{ 'active_item': item.active}" v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                        <span v-if="hasSubmenu" class="pi pi-fw pi-angle-down ml-2" />
                    </Link>

                </template>

                <template #end>
                    <Button @click.prevent="logout" icon="pi pi-sign-out" aria-label="Выйти" />
                </template>
            </Menubar>
        </div>
    </section>
</template>

<script setup>
    import Menubar from 'primevue/menubar';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3'
    import { Link } from '@inertiajs/vue3'

    let items = ref([
        {
            label: 'Главная',
            icon: 'pi pi-home',
            url: route('home'),
            active:true,
            command: (menu_item)=> {
                setActive(menu_item.item)
            }
        },
        {
            label: 'Сайты',
            icon: 'pi pi-star',
            url: route('site.index'),
            active:false,
            command: (menu_item)=> {
                setActive(menu_item.item)
            }
        }
    ])

    const logout = () => {
        router.visit(route('logout_do'), { method:'get' })
            // .then((resp) => {
            //     router.visit(route('login'))
            // })
    }

    const setActive = (item) => {
        items.value.forEach((element)=>{
            element.active = (element.label == item.label)
        })
    }

    setActive(items.value[0])
</script>
