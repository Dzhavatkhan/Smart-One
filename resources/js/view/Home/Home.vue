<template>
    <Header></Header>
    <Main></Main>
    <Footer></Footer>
    <MobileMenu class="hidden max-md:flex max-sm:flex"></MobileMenu>
</template>

<script setup>
    import Header from './../../components/sections/home/Header.vue'
    import Footer from './../../components/sections/home/Footer.vue'
    import Main from './../../components/sections/home/Main.vue'
    import MobileMenu from "../../components/structure/Index.vue"
</script>

<style scoped>
    .router-link-active {
        color: black;
        font-family: "Roboto";
        font-weight: 700;
    }
</style>
