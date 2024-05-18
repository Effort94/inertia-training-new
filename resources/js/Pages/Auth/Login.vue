<template>
    <main class="grid place-items-center min-h-screen">
        <h1 class="text-3xl mb-6">Log In</h1>

        <form @submit.prevent="submit">
            <div class="form-group mb-4">
                <label for="exampleInputEmail1">Email</label>
                <input v-model="form.email" type="email" class="form-control" id="email" placeholder="Email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>

                <div v-if="form.errors.email" v-text="form.errors.email" class="text-danger text-sm-start"></div>
            </div>

            <div class="form-group mb-4">
                <label for="password">Password</label>
                <input v-model = form.password type="password" class="form-control" id="password" placeholder="Password">

                <div v-if="form.errors.password" v-text="form.errors.password" class="text-danger text-sm-start"></div>
            </div>

            <div>
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing"
                >
                    Log In
                </button>
            </div>
        </form>
    </main>
</template>

<script>
export default {
    layout: null,
};
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
let form = useForm({
    email: '',
    password: '',
});
let submit = () => {
    form.post('/login');
};
</script>
