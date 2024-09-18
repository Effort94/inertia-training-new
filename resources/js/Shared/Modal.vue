<template>
    <!-- Modal Background Overlay -->
    <div ref="modalOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click="handleOverlayClick">
        <!-- Modal Container -->
        <div class="rounded-lg w-full max-w-lg p-6 dark:bg-gray-800">

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <slot name="header"></slot>
                </h3>
                <button type="button" @click="close" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="mb-4 border-b dark:border-gray-600 p-4">
                <slot name="body"></slot>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-between">
                <Button
                    type="button"
                    name="Close"
                    class="btn btn-default"
                    @click="close"
                >
                    Close
                </Button>
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>
<script>

import Button from "@/Shared/Form/Button.vue";

export default {
    components: {
      Button
    },
    props: {
        modalSize: {
            type: String,
            default: 'modal-default'
        },
    },
    methods: {
        /**
         * Emit close modal event
         */
        close() {
            this.$emit('close');
        },
        /**
         * Handle clicks on the overlay
         */
        handleOverlayClick(event) {
            if (event.target === this.$refs.modalOverlay) {
                this.close();
            }
        }
    },
};
</script>
