<template>
    <Layout>
        <div v-if="success.length > 0" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                {{ success }}
            </div>
        </div>

        <div class="flex flex-grow justify-center items-center">
            <form class="w-full max-w-lg rounded px-16 pt-8 pb-10 dark:bg-gray-900" @submit.prevent="save">
                <h1 class="text-3xl mb-6 dark:text-white">Account Settings</h1>

                <div class="mb-6">
                    <Text name="Email" v-model="form.email" type="email"></Text>
                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-sm mt-2"></div>
                </div>

                <div class="mb-6">
                    <Text name="Password" v-model="form.password" type="password"></Text>
                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-sm mt-2"></div>
                </div>

                <div class="mb-6">
                    <Text name="Confirm Password" v-model="form.password_confirmation" type="password"></Text>
                    <div v-if="form.errors.password_confirmation" v-text="form.errors.password_confirmation" class="text-red-500 text-sm mt-2"></div>
                </div>

                <Button name="Save" class="w-full" @click="save"></Button>
            </form>
        </div>
    </Layout>
</template>

<script>
    import Layout from "@/Shared/Layout.vue"
    import { useForm } from '@inertiajs/vue3';
    import Text from "@/Shared/Form/Text.vue";
    import Button from "@/Shared/Form/Button.vue";

    export default {
        components: {
            Text,
            Layout,
            Button
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
            /**
             * Saves account settings
             */
            save() {
                this.success = {};
                this.errors = {};

                this.form.post('/users/' + this.$page.props.auth.user.id + '/settings/update', {
                    onSuccess: () => {
                        this.success = this.$page.props.flash.success
                    },
                });
            }
        },
    }
</script>
