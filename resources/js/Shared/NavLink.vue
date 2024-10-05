<template>
    <component :is="isLink ? 'Link' : 'span'" :href="isLink ? href : undefined" :class="linkClasses">
        <slot />
    </component>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    components: { Link },
    props: {
        active: {
            type: Boolean,
            default: false,
        },
        isLink: {
            type: Boolean,
            default: true,
        },
        href: {
            type: String,
            default: '#',
        },
    },
    computed: {
        linkClasses() {
            return {
                'bg-gray-900 text-white rounded-md px-3 py-2': this.active,
                'text-white': !this.active && this.isLink,
                'cursor-pointer': !this.isLink
            };
        }
    }
}
</script>
