<template>
    <header class="header flex flex-col px-[200px] pt-[50px] w-full gap-[65px]">
        <div class="info flex justify-between  text-[16px] font-[Roboto]">
            <select name="" id="" class="city outline-none w-[101px]">
                <option selected value="">Астрахань</option>
            </select>
            <p class="phone">+7-961-816-85-84</p>
        </div>
        <div class="header-content flex gap-[45px] justufy-between">
            <img src="/public/img/home/header/Logo.svg" alt="">
            <div class="header-center flex">
                <div class="seacrhCatalog flex gap-[16px]">
                    <Catalog></Catalog>
                    <Search></Search>
                </div>
            </div>
            <div class="icons flex gap-[45px] items-center">
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
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();    
    const router = useRouter();

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
