<script>
import { Link } from "@inertiajs/vue3";
export default {
    components: { Link },

    props: {
        active: Boolean,
    }
}

</script>

<template>
    <Link :class="{'bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium' : active }">
        <slot />
    </Link>
</template>

<style scoped>

</style>
