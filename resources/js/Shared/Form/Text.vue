<template>
    <div>
        <label class="block text-gray-700 dark:text-gray-300 mb-2" :for="id">{{ name }}</label>
        <input
            :id="id"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :type="type"
        >
    </div>
</template>

<script>
export default {
    components: {

    },

    props: {
        name: {
            type: String,
            required: true,
            default: null
        },

        type: {
            type: String,
            required: false,
            default:'text'
        }
    },

    data() {
        return {

        }
    },

    methods() {

    },

    computed: {
        id() {
            return 'text-' + Math.floor(Math.random() * 100000);
        }
    },
}
</script>
