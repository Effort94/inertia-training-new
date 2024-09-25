<template>

    <!--    Left Menu -->
    <nav class="bg-gray-800">
        <div class="mx-auto px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <NavLink :href="getUrl()" :active="$page.component === 'Home'">Home</NavLink>
                            <Dropdown>
                                <template v-slot:button>
                                    <NavLink class="flex items-center" :active="$page.component === 'Tasks/Index'" :is-link="false">
                                        Projects
                                        <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/>
                                        </svg>
                                    </NavLink>
                                </template>
                                <template v-slot:content>
                                    <NavLink class="flex rounded px-4 py-2 hover:bg-gray-700 dark:hover:bg-gray-600" :href="getUrl('login')">
                                        Authentication
                                    </NavLink>
                                    <NavLink class="flex rounded px-4 py-2 hover:bg-gray-700 dark:hover:bg-gray-600" :href="getUrl('tasks')">
                                        Tasks
                                    </NavLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>

                <!-- Right Menu    -->
                <div v-if="isAuthorised" class="right">
                    <div class="ml-4 flex items-center md:ml-6">
                        <Dropdown>
                            <template v-slot:button>
                                <NavLink class="flex items-center" :active="$page.component === 'settings'" :is-link="false">
                                    {{  name }}
                                    <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/>
                                    </svg>
                                </NavLink>
                            </template>
                            <template v-slot:content>
                                <NavLink class="flex rounded px-4 py-2 hover:bg-gray-700 dark:hover:bg-gray-600" :href="getUrl('settings')">
                                    Settings
                                </NavLink>
                                <hr>
                                <NavLink class="flex rounded px-4 py-2 hover:bg-gray-700 dark:hover:bg-gray-600" :href="getUrl('logout')">
                                    Logout
                                </NavLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
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

        methods: {
            getUrl(pageName) {
                const pageUrls = {
                    login: `/login`,
                    tasks: `/tasks`,
                    logout: '/logout'
                };

                if (this.isAuthorised) {
                    pageUrls.settings = `/users/${this.$page.props.auth.user.id}/settings`
                }
                return pageUrls[pageName] || '/';
            },
        },
        computed: {
            isAuthorised() {
                return this.$page.props.auth !== null
            },
            name() {
                return this.$page.props.auth.user.name
            },
        }
    }

</script>
