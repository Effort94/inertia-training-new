<template>
    <Layout>
        <div class="flex flex-grow justify-center items-center">
            <form class="w-full max-w-md shadow-md rounded px-16 pt-8 pb-14 mb-4 bg-white dark:bg-gray-900" @submit.prevent="submit">
                <h1 class="text-3xl mb-6 dark:text-white">Register</h1>

                <div class="mb-6">
                    <Text name="Name" v-model="form.name"></Text>
                    <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-sm mt-2"></div>
                </div>

                <div class="mb-6">
                    <Text name="Email" v-model="form.email"></Text>
                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-sm mt-2"></div>
                </div>

                <div class="mb-6">
                    <Text name="Password" type="password" v-model="form.password"></Text>
                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-sm mt-2"></div>
                </div>

                <div class="mb-6">
                    <Text name="Confirm Password" type="password" v-model="form.password_confirmation"></Text>
                    <div v-if="form.errors.password_confirmation" v-text="form.errors.password_confirmation" class="text-red-500 text-sm mt-2"></div>
                </div>

                <Button class="w-full bg-blue-500 mb-6 dark:bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-600 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500" name="Register" eventName="submit"></Button>

                <hr>

                <p class="mt-4 text-gray-700 dark:text-gray-300">Already have have an account? <a href="login" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Login</a> </p>
            </form>
        </div>
    </Layout>
</template>

<script>
    import { useForm } from '@inertiajs/vue3';
    import Text from "@/Shared/Form/Text.vue";
    import Button from "@/Shared/Form/Button.vue";
    import Layout from "@/Shared/Layout.vue";

    export default {
        components: {
            Text,
            Button,
            Layout
        },

        data() {
            return {
                form: useForm({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            }
        },
        methods: {
            submit() {
                this.form.post('/register');
            }
        }
    }
</script>
