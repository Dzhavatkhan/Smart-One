<template>
    <Header></Header>
    <div class="px-[200px] w-full min-h-[400px] flex gap-[90px] mb-[93px] pt-[139px] max-md:pt-[30px] max-md:px-5 max-sm:pt-[30px] max-sm:px-5">
        <div class="flex flex-col gap-4 h-[133px] w-[247px] max-md:hidden max-sm:hidden">
            <router-link to="/profile/me" class="flex flex-col gap-[13px] w-full">
                <div class="route w-full">
                    Личный кабинет
                </div>
                <div class="lane bg-[#A4A4A4] h-[1px] w-full"></div>

            </router-link>
            <router-link class="flex flex-col gap-[13px] w-full" to="/profile/favorite">
                <div class="route w-full">
                    Избранное
                </div>
                <div class="lane bg-[#A4A4A4] h-[1px] w-full"></div>
            </router-link>
            <router-link class="flex flex-col gap-[13px] w-full" to="/profile/cart">
                <div class="route w-full">Корзина</div>
                <div class="lane bg-[#A4A4A4] h-[1px] w-full"></div>
            </router-link>
        </div>
        <div id="ProfileView" class="w-full min-h-[133px]">
            <router-view class="w-full h-full" ></router-view>
        </div>
    </div>

    <Footer></Footer>
    <MobileMenu class="hidden max-md:flex max-sm:flex"></MobileMenu>
</template>

<script setup>
    import Header from './../../components/sections/home/Header.vue';
    import Footer from './../../components/sections/home/Footer.vue';
    import MobileMenu from "./../../components/structure/Index.vue"


</script>

<style scoped>
.router-link-active {
    color: black;
    font-family: "Roboto";
    font-weight: 700;
}
.router-link-active .lane{
    background-color: black;
}
</style>
