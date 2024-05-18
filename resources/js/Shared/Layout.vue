<script>
import Header from "./Header.vue";
import Footer from './Footer.vue';

export default {
    components: { Header, Footer },
}
</script>

<template>
    <Header></Header>

    <slot />

    <Footer></Footer>

</template>
