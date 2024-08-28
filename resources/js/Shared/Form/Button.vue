<template>
    <button
        @click="submit()"
        class="w-full bg-blue-500 dark:bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-600 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
        type="submit"
    >
        {{ name }}
    </button>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
            default: null
        },
        eventName: {
            type: String,
            required: true,
        }
    },
    methods: {
        submit() {
            this.$emit(this.eventName)
        }
    }
}
</script>
