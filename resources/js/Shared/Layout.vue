<script>
import Header from "./Header.vue";
import Footer from './Footer.vue';

export default {
    components: { Header, Footer },
}
</script>

<template>
    <div class="flex flex-col min-h-screen w-full bg-gray-900">
        <Header></Header>
        <div class="flex-1 flex flex-col w-full h-full">
            <slot></slot>
        </div>
        <Footer></Footer>
    </div>
</template>
