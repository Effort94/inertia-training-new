<template class="dark">
    <v-dropdown placement="right">
        <template v-slot:button>
            <span class="mr-2">{{ name }}</span>
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/>
            </svg>
        </template>

        <template v-slot:content>
            <button class="flex w-full justify-between items-center rounded px-2 py-1 my-1 hover:bg-gray-700" @click="goToSettings">Settings</button>
            <hr class="border-gray-300 dark:border-gray-600"/>
            <button class="flex w-full justify-between items-center rounded px-2 py-1 my-1 hover:bg-gray-700" @click="signOut">Logout</button>
        </template>
    </v-dropdown>
</template>


<script>
import VDropdown from "@/Shared/v-dropdown.vue";
export default {
    name: "AccountSettingsDrodown.vue",
    components: {
        VDropdown
    },

    computed: {
        name() {
            return this.$page.props.auth.user.name
        },

        isAuthorised() {
            return this.$page.props.auth !== null
        }
    },

    methods: {
        goToSettings() {
            this.$inertia.visit('/users/' + this.$page.props.auth.user.id + '/settings');
        },
        async signOut() {
            try {

                const response = await this.$axios.post('/logout');

                if (response.status === 200) {
                    this.$inertia.visit('/login');
                }
            } catch (error) {
                console.error('Logout failed:', error);
            }
        }
    }

}
</script>
