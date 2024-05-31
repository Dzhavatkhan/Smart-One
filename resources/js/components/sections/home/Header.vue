<template>
    <header class="header flex flex-col px-[200px] pt-[50px] w-full gap-[65px] max-sm:shadow-lg max-sm:flex-row max-sm:h-[55px] max-sm:gap-0 max-sm:py-0 max-sm:px-5">
        <div class="info flex justify-between text-[16px] font-[Roboto] max-sm:hidden">
            <select name="" id="" class="city outline-none w-[101px]">
                <option selected value="">Астрахань</option>
            </select>
            <p class="phone">+7-961-816-85-84</p>
        </div>
        <div class="header-content flex gap-[45px] justufy-between max-sm:w-full max-sm:gap-[88px] max-sm:items-center">
            <Menu></Menu>
            <img @click="home" src="/public/img/home/header/Logo.svg" class="max-sm:w-[174px] cursor-pointer max-sm:h-full" alt="">
            <img src="/public/img/home/header/SearchMobile.svg" alt="" class="hidden max-sm:flex max-sm:w-5 max-sm:h-5">
            <div class="header-center flex max-sm:hidden">
                <div class="seacrhCatalog flex gap-[16px]">
                    <Catalog></Catalog>
                    <div class="flex flex-col">
                        <Search></Search>
                    </div>
                </div>
            </div>
            <div class="icons flex gap-[45px] items-center max-sm:hidden">
                <img @click="toProfile" class="cursor-pointer hover:opacity-85 h-[50px]" src="/public/img/home/header/Male User.svg" alt="">
                <img @click="toFavorite" class="cursor-pointer hover:opacity-85 h-[50px]" src="/public/img/home/header/Heart.svg" alt="">
                <img @click="toCart" class="cursor-pointer hover:opacity-85 h-[50px]" src="/public/img/home/header/Shopping Cart.svg" alt="">
            </div>
        </div>
    </header>
</template>

<script setup>
    import { useRouter } from 'vue-router';
    import Catalog from '../../modals/home/Catalog.vue';
    import Search from '../../modals/home/Search.vue'
    import Menu from './../../modals/home/Menu.vue'
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();
    const router = useRouter();

    const home = () => {
        router.push("/")
    }
    const toProfile = () => {
        if (userStore.id == null) {
            router.push("/login")
        }
        else{
            router.push("/profile/me")
        }
    }
    const toFavorite = () => {
        if (userStore.id == null) {
            router.push("/login")
        }
        else{
            router.push("/profile/favorite")
        }
    }
    const toCart = () => {
        if (userStore.id == null) {
            router.push("/login")
        }
        else{
            router.push("/profile/cart")
        }
    }
</script>

<style scoped>

</style>
