<template>
    <Header></Header>
    <div class="px-[200px] w-full h-full flex gap-[90px] pt-[139px] pb-[93px]">

        <div class="flex flex-col gap-4 h-[133px] w-[247px]">
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
        <div id="ProfileView">
            <router-view ></router-view>
        </div>
    </div>

    <Footer></Footer>
</template>

<script setup>
    import Header from './../../components/sections/home/Header.vue';
    import Footer from './../../components/sections/home/Footer.vue';


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
