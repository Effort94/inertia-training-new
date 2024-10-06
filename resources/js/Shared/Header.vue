<template>
    <nav class="flex items-center h-20 gap-2 px-4 shadow-lg bg-gray-800 text-white dark:bg-gray-900 dark:shadow-gray-700">
        <ul class="flex space-x-6 text-lg font-semibold text-gray-500 hover:text-gray-900 dark:text-white dark:hover:text-gray-400">
            <li>
                <NavLink :href="getUrl('home')" class="hover:text-gray-300 dark:hover:text-gray-400">Home</NavLink>
            </li>
            <li>
                <NavLink :href="getUrl('showcase')" class="hover:text-gray-300 dark:hover:text-gray-400">Showcase</NavLink>
            </li>
        </ul>

        <!-- Right Menu (Admin) -->
        <div v-if="isAuthorised" class="ml-auto flex items-center">
            <Dropdown :user="$page.props.auth.user">
                <template v-slot:button>
                  <span class="flex items-center">
                    <span>{{ name }}</span>
                  </span>
                </template>
            </Dropdown>
        </div>
    </nav>
</template>

<script>
import NavLink from "./NavLink.vue";
import Dropdown from "@/Shared/Form/Dropdown.vue";

export default {
    components: {
        NavLink,
        Dropdown
    },

    computed: {
        isAuthorised() {
            return this.$page.props.auth !== null;
        },
        name() {
            return this.$page.props.auth.user.name;
        }
    },

    methods: {
        getUrl(pageName) {
            const pageUrls = {
                home: '/',
                showcase: '/showcase'
            };

            return pageUrls[pageName] || '/';
        }
    }
};
</script>
