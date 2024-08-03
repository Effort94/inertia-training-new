<template>

    <div class="h-screen flex justify-center items-center">
        <form class="w-full max-w-md shadow-md rounded px-16 pt-8 pb-14 mb-4 bg-white dark:bg-gray-800" @submit.prevent="submit">
            <h1 class="text-3xl mb-6 dark:text-white">Login</h1>

            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="email">Email</label>
                <input v-model="form.email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" name="email">

                <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="password">Password</label>
                <input v-model="form.password" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="email">

                <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-sm mt-2"></div>
            </div>

            <button @click="submit()" class="w-full bg-blue-500 mb-6 dark:bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-600 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500" type="submit">Login</button>

            <hr>

            <p class="mt-4 text-gray-700 dark:text-gray-300">Don't have an account? <a href="register" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Register</a> </p>
        </form>
    </div>
</template>

<script>
    import { useForm } from '@inertiajs/vue3';
    import { FwbButton, FwbInput} from 'flowbite-vue'

    export default {
        components: {
            FwbButton,
            FwbInput
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
            submit() {
                this.form.post('/login');
            }
        }
    }
</script>
