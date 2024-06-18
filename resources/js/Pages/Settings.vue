<template>
    <Layout>
        <div v-if="success.length > 0" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                {{ success }}
            </div>
        </div>

        <div class="flex justify-center items-center py-32">
            <form class="w-3/4 max-w-screen-lg shadow-md rounded px-16 pt-8 pb-10 mb-4 bg-white dark:bg-gray-800" @submit.prevent="update">
                <h1 class="text-3xl mb-6 dark:text-white">Account Settings</h1>

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

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2" for="email">Confirm Password</label>
                    <input v-model="form.password_confirmation" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="email">
                    <div v-if="form.errors.password_confirmation" v-text="form.errors.password_confirmation" class="text-red-500 text-sm mt-2"></div>
                </div>

                <button @click="update()" class="w-full bg-blue-500 dark:bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-600 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500" type="submit">Update</button>
            </form>
        </div>
    </Layout>
</template>

<script>
    import Layout from "@/Shared/Layout.vue"
    import {useForm, usePage} from '@inertiajs/vue3';

    export default {
        components: {
            Layout
        },

        data() {
            return {
                form: useForm({
                    email: this.$page.props.auth.user.email,
                    password: '',
                    password_confirmation: ''
                }),
                success: {},
                errors: {}
            };
        },

        methods: {
            update() {
                this.success = {};
                this.errors = {};

                this.form.post('/users/' + this.$page.props.auth.user.id + '/settings/store', {
                    onSuccess: () => {
                        this.success = this.$page.props.flash.success
                    },
                });
            }
        },
    }
</script>
