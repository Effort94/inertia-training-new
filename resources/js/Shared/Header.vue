<template>
    <div class="w-full text-white sticky top-0 z-50">
        <NavBarLinks></NavBarLinks>
    </div>
</template>

<script>
import NavBarLinks from './NavBar.vue'
import NavLink from "./NavLink.vue";
export default {
    components: {
        NavLink,
        NavBarLinks
    },

    data() {
        return {
            active: false,
        }
    },
}
</script>
