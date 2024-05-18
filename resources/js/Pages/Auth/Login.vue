<template>
    <div class="h-screen flex items-center justify-center">
        <div class="container px-4">
            <form class="bg-white shadow-md rounded px-16 pt-6 pb-8 mb-4" @submit.prevent="submit">
                <h1 class="text-3xl mb-6">Log In</h1>

                <div class="mb-4">
                    <fwb-input
                        v-model="form.email"
                        placeholder="Email"
                        label="Email"
                    />
                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-danger text-sm-start"></div>
                </div>

                <div class="mb-4">
                    <fwb-input
                        v-model="form.password"
                        placeholder="Password"
                        label="Password"
                    />
                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-danger text-sm-start"></div>
                </div>

                <fwb-button @click="submit">Login</fwb-button>
            </form>
        </div>
    </div>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import { FwbButton, FwbInput} from 'flowbite-vue'

    let form = useForm({
        email: '',
        password: '',
    });
    let submit = () => {
        form.post('/login');
    };
</script>
