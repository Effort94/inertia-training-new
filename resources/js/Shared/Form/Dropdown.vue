<template>
    <div class="relative inline-block text-left">
        <button
            class="flex items-center space-x-2 text-lg font-semibold text-gray-700 hover:text-gray-900 dark:text-white dark:hover:text-gray-300 focus:outline-none"
            @click="toggleDropdown"
            aria-haspopup="true"
            aria-expanded="open.toString()"
            @keydown.enter="toggleDropdown"
            @keydown.space.prevent="toggleDropdown"
        >
            <span>{{ user.name }}</span>
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M5 8l5 5 5-5H5z"/>
            </svg>
        </button>

        <button
            class="fixed inset-0 h-full w-full cursor-default focus:outline-none"
            v-if="open"
            @click="closeDropdown"
            tabindex="-1"
        ></button>

        <transition
            enter-active-class="transition-all duration-200 ease-out"
            leave-active-class="transition-all duration-200 ease-in"
            enter-class="opacity-0 scale-75"
            enter-to-class="opacity-100 scale-100"
            leave-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-75"
        >
            <div
                class="absolute right-0 z-50 mt-2 w-56 rounded-lg shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
                v-if="open"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="account-menu"
            >
                <div class="py-1">
                    <NavLink
                        class="flex items-center px-4 py-2 text-md text-gray-800 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                        :href="`/users/${this.$page.props.auth.user.id}/settings`"
                    >
                        Account Settings
                    </NavLink>

                    <hr>

                    <NavLink
                        class="flex items-center px-4 py-2 text-md text-gray-800 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                        :href="`/logout`"
                    >
                        Log Out
                    </NavLink>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import NavLink from "@/Shared/NavLink.vue";

export default {
    components: {
      NavLink
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            open: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.open = !this.open;
        },
        closeDropdown() {
            this.open = false;
        },
    },
};
</script>

<style scoped>
.fixed {
    outline: none; /* Remove default outline for the dropdown */
}
</style>
