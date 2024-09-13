<template>
    <div class="max-w space-y-3">
        <label class="block font-medium text-gray-900 dark:text-white" :for="id">{{ name }}</label>
        <div class="col-span-2 sm:col-span-1">
            <select
                id="category"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                :value="modelValue"
                @change="$emit('update:modelValue', $event.target.value)"
            >
                <option selected="">Please Select</option>
                <option value="1">Low</option>
                <option value="2">Medium</option>
                <option value="3">High</option>
            </select>
        </div>
    </div>
</template>
<script>
export default {
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
        },

        modelValue: {
            type: String,
            default: ''
        }
    },
    computed: {
        id() {
            return 'text-' + Math.floor(Math.random() * 100000);
        }
    },
}
</script>
