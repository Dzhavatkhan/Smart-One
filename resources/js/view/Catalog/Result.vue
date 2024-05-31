<template>
        <Header></Header>
        <div class="w-full h-full px-[200px]">
            {{ category }}
            {{ subcategory }}
        </div>
        <Footer></Footer>

</template>

<script setup>
    import Footer from "../../components/sections/home/Footer.vue";
    import Header from "../../components/sections/home/Header.vue"

    let props = defineProps({
        category: {
            type:String,
            default: ''
        },
        subcategory: {
            type:String,
            default: ''
        }
    });
</script>

<style scoped>

</style>