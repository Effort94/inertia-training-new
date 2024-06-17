<template>
    <div class="w-full text-white">
        <fwb-navbar solid>
            <div class="align-items-start">
                <fwb-navbar-collapse>
                    <fwb-navbar-link>
                        Home
                    </fwb-navbar-link>
                </fwb-navbar-collapse>
            </div>

            <div v-if="isAuthorised">
                <fwb-dropdown :text="name" class="bg-gray-800 text-white">
                    <fwb-list-group class="w-32">
                        <fwb-list-group-item @click="goToSettings" hover>
                            Settings
                        </fwb-list-group-item>
                        <fwb-list-group-item @click="signOut" hover>
                            Log Off
                        </fwb-list-group-item>
                    </fwb-list-group>
                </fwb-dropdown>
            </div>
            <div v-if="!isAuthorised">
                <fwb-button>
                    Get started
                </fwb-button>
            </div>
        </fwb-navbar>
    </div>
</template>

<script>
import {
    FwbButton,
    FwbNavbar,
    FwbDropdown,
    FwbNavbarCollapse,
    FwbNavbarLink,
    FwbNavbarLogo, FwbListGroup, FwbListGroupItem,
} from 'flowbite-vue'
export default {
    components: {
        FwbListGroupItem,
        FwbListGroup, FwbNavbar, FwbDropdown, FwbButton, FwbNavbarCollapse, FwbNavbarLink, FwbNavbarLogo },

    data() {
        return {
            active: false,
        }
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
