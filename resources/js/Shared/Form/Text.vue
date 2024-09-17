<template>
    <div class="max-w space-y-3">
        <label class="block font-medium text-gray-900 dark:text-white" :for="id">{{ name }}</label>
        <div class="relative">
            <input
                :id="id"
                :type="showPassword && type === 'password' ? 'text' : type"
                :value="modelValue"
                :disabled="disabled"
                @input="$emit('update:modelValue', $event.target.value)"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            />
            <div class="absolute inset-y-0 end-0 flex items-center z-20 pe-4">
                <button
                    v-if="type === 'password'"
                    type="button"
                    class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500 dark:text-gray-300"
                    @click.prevent="showPassword = !showPassword"
                >
                    <i class="far fa-fw" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
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
        },
        disabled: {
            type: Boolean,
            default: false,
        }
    },
    data() {
      return {
          showPassword: false,
      }
    },
    computed: {
        id() {
            return 'text-' + Math.floor(Math.random() * 100000);
        }
    },

    methods: {
        toggleShow() {
            this.showPassword = !this.showPassword
        }
    }
}
</script>
