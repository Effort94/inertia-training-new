<template>
    <nav class="flex items-center h-20 gap-2 px-4 shadow-lg bg-gray-800 text-white dark:bg-gray-900 dark:shadow-gray-700">
        <ul class="flex space-x-6 text-lg font-semibold text-gray-500 hover:text-gray-900 dark:text-white dark:hover:text-gray-400">
            <li>
                <NavLink :href="getUrl('home')" class="hover:text-gray-300 dark:hover:text-gray-400">Home</NavLink>
            </li>
            <li>
                <NavLink :href="getUrl('about')" class="hover:text-gray-300 dark:hover:text-gray-400">About</NavLink>
            </li>
            <li>
                <NavLink :href="getUrl('projects')" class="hover:text-gray-300 dark:hover:text-gray-400">Projects</NavLink>
            </li>
            <li>
                <NavLink :href="getUrl('contact')" class="hover:text-gray-300 dark:hover:text-gray-400">Contact</NavLink>
            </li>
        </ul>
    </nav>

    <!-- Right Menu -->
    <div v-if="isAuthorised" class="ml-4 flex items-center">
        <Dropdown>
            <template v-slot:button>
      <span class="flex items-center hover:text-gray-300 dark:hover:text-gray-400">
        {{ name }}
        <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/>
        </svg>
      </span>
            </template>
            <template v-slot:content>
                <NavLink class="flex rounded px-4 py-2 hover:bg-gray-700 dark:hover:bg-gray-600" :href="getUrl('settings')">Settings</NavLink>
                <hr>
                <NavLink class="flex rounded px-4 py-2 hover:bg-gray-700 dark:hover:bg-gray-600" :href="getUrl('logout')">Logout</NavLink>
            </template>
        </Dropdown>
    </div>
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
                about: '/about',
                projects: '/projects',
                contact: '/contact',
                logout: '/logout'
            };

            if (this.isAuthorised) {
                pageUrls.settings = `/users/${this.$page.props.auth.user.id}/settings`
            }

            return pageUrls[pageName] || '/';
        }
    }
};
</script>
