<template>
    <!-- Modal Background Overlay -->
    <div v-if="isVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <!-- Modal Container -->
        <div class="rounded-lg w-full max-w-lg p-6 dark:bg-gray-800">

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create Task
                </h3>
                <button type="button" @click="close" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="mb-4 border-b dark:border-gray-600 p-4">
                <div class="mb-6">
                    <Text name="Title" v-model="form.title"></Text>
                    <div v-if="form.errors.title" v-text="form.errors.title" class="text-red-500 text-sm mt-2"></div>
                </div>
                <div class="mb-6">
                    <Text name="Description" v-model="form.description"></Text>
                    <div v-if="form.errors.description" v-text="form.errors.description" class="text-red-500 text-sm mt-2"></div>
                </div>
                <div class="mb-6">
                    <Select name="Priority" v-model="form.priority"></Select>
                    <div v-if="form.errors.priority" v-text="form.errors.priority" class="text-red-500 text-sm mt-2"></div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-between">
                <Button
                    name="Close"
                    @click="close"
                    class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700"
                >
                    Cancel
                </Button>
                <Button
                    name="Create"
                    @click="create"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                >
                    Create
                </Button>
            </div>
        </div>
    </div>
</template>

<script>

import Text from "@/Shared/Form/Text.vue";
import Select from "@/Shared/Form/Select.vue";
import Button from "@/Shared/Form/Button.vue";
import {useForm} from "@inertiajs/vue3";
export default {
    components: {
        Text,
        Select,
        Button
    },
    props: {
        title: {
            type: String,
            default: 'Modal Title',
        },
        isVisible: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            form: useForm({
                title: '',
                description: '',
                priority: '',
            }),
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        create() {
            this.form.post('/tasks/create')
        },
    },
};
</script>
