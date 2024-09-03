<template>
    <div class="relative ">
        <button class="z-10 relative flex items-center select-none focus:outline-none" @click="open = !open">
            <slot name="button"></slot>
        </button>

        <!-- to close when clicked on space around it-->
        <button class="fixed inset-0 h-full w-full cursor-default focus:outline-none" v-if="open" @click="open = false"
                tabindex="-1"></button>

        <!--dropdown menu-->
        <transition enter-active-class="transition-all duration-200 ease-out"
                    leave-active-class="transition-all duration-750 ease-in" enter-class="opacity-0 scale-75"
                    enter-to-class="opacity-100 scale-100" leave-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-75">
            <div class="fixed mt-2 w-48 rounded-lg py-1 px-2 text-sm dark:bg-gray-800 z-50" v-if="open">
                <slot name="content"></slot>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            open: false,
        };
    },
    mounted() {
        const onEscape = (e) => {
            if (e.key === "Esc" || e.key === "Escape") {
                this.open = false;
            }
        };

        document.addEventListener("keydown", onEscape);
    },
};
</script>
