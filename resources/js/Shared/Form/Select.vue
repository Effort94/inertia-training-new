<template>
    <div class="max-w space-y-3">
        <label class="block font-medium text-gray-900 dark:text-white" :for="id">{{ name }}</label>
        <div class="col-span-2 sm:col-span-1">
            <select
                :id="id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                :value="modelValue"
                :disabled="disabled"
                @change="$emit('update:modelValue', Number($event.target.value))"
            >
                <option value="" disabled>Please Select</option>
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.text }}
                </option>
            </select>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        id: {
            type: String,
            required: true
        },
        name: {
            type: String,
            required: true,
            default: null
        },
        modelValue: {
            type: Number,
            default: 0
        },
        disabled: {
            type: Boolean,
            default: false
        },
        options: {
            type: Array,
            required: true
        }
    }
}
</script>
