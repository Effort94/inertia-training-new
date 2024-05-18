<template>
    <div class="dark flex text-white">
        <div class="w-full">
            <fwb-navbar solid>
                <div class="align-items-start">
                        <fwb-navbar-collapse>
                            <fwb-navbar-link is-active link="/">
                                Home
                            </fwb-navbar-link>
                            <fwb-navbar-link link="/settings">
                                Settings
                            </fwb-navbar-link>
                        </fwb-navbar-collapse>
                </div>

                <div class="align-items-end">
                    <div v-if="isAuthorised">
                        <fwb-dropdown :text="name">
                            <fwb-list-group class="w-32">
                                <fwb-list-group-item @click="signOut" hover>Log Off</fwb-list-group-item>
                            </fwb-list-group>
                        </fwb-dropdown>
                    </div>
                    <div v-if="!isAuthorised">
                        <fwb-button>
                            Get started
                        </fwb-button>
                    </div>
                </div>
            </fwb-navbar>
        </div>
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
