<template>
    <div class="max-w space-y-3">
        <div>
            <label class="block text-gray-700 dark:text-gray-300" :for="id">{{ name }}</label>
            <div class="relative">
                <input
                    :id="id"
                    :type="showPassword && type === 'password' ? 'text' : type"
                    :value="modelValue"
                    @input="$emit('update:modelValue', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
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
