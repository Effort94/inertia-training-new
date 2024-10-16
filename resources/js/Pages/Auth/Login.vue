<template>
    <Layout>
        <div class="flex flex-grow justify-center items-center">
            <form class="w-full max-w-md rounded p-16 dark:bg-gray-900" @submit.prevent="submit">
                <h1 class="text-3xl mb-6 dark:text-white">Login</h1>

                <div class="mb-6">
                    <Text name="Email" v-model="form.email" type="email"></Text>
                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-sm mt-2"></div>
                </div>

                <div class="mb-6">
                    <Text name="Password" type="password" v-model="form.password"></Text>
                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-sm mt-2"></div>
                </div>

                <Button name="Login" @click="submit" class="w-full mb-6"></Button>

                <hr>

                <p class="mt-4 text-gray-700 dark:text-gray-300">Don't have an account? <a href="register" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Register</a> </p>
            </form>
        </div>
    </Layout>
</template>

<script>
    import { useForm } from '@inertiajs/vue3';
    import Layout from "@/Shared/Layout.vue";
    import Text from "@/Shared/Form/Text.vue";
    import Button from "@/Shared/Form/Button.vue";

    export default {
        components: {
            Layout,
            Text,
            Button
        },

        data() {
            return {
                form: useForm({
                    email: '',
                    password: ''
                })
            }
        },
        methods: {
            /**
             * Submit the form
             */
            submit() {
                this.form.post('/login');
            }
        }
    }
</script>
