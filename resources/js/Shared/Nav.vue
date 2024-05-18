<template>
    <nav class="mx-6">
        <ul>
            <li>
                <NavLink href="/" :active="$page.component === 'Home'">Home</NavLink>
            </li>

            <li>
                <NavLink href="/settings" :active="$page.component === 'Settings'">Settings</NavLink>
            </li>
        </ul>
    </nav>
</template>

<script>
    import NavLink from "./NavLink.vue";

    export default {
        components: {NavLink },
    }

</script>
