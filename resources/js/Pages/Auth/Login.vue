<template>
    <Head>
        <title>Авторизация</title>
    </Head>
    <div class="full_screen_blk">
        <form class="auth_box">
            <h2>Войти</h2>
            <IconField>
                <InputIcon class="pi pi-user" />
                <InputText v-model="loginForm.email" placeholder="Логин" />
            </IconField>

            <br>

            <IconField>
                <InputIcon class="pi pi-key" />
                <Password v-model="loginForm.password" placeholder="Пароль" toggleMask :feedback="false" />
            </IconField>

            <br>

            <Button @click.prevent="autorize" label="Войти" icon="pi pi-sign-in" />
        </form>
    </div>
</template>

<script setup>
    import { useForm, Head, router } from '@inertiajs/vue3';
    import Auth from '../../Layouts/Auth.vue';

    import { useToast } from "primevue/usetoast";
    const toast = useToast();

    defineOptions({
        layout: Auth,
    });

    const loginForm = useForm( {
        email: null,
        password: null
    })

    const autorize = () => {
        loginForm.post(route('login_do'), {
            onError: errors => {
                console.log(errors)
                Object.keys(errors).forEach(element => {
                    toast.add({ severity: 'error', summary: "Ошибка авторизации", detail: errors[element], life: 5000 });
                });
            },
        })
    }

</script>
