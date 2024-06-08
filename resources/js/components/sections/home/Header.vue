<template>
    <header class="header flex flex-col px-[200px] pt-[50px] w-full gap-[65px] max-md:shadow-lg max-md:flex-row max-md:justify-center max-md:h-max max-md:gap-0 max-md:py-0 max-md:px-5 max-sm:shadow-lg  max-sm:flex-row max-sm:h-[55px] max-sm:gap-0 max-sm:py-0 max-sm:px-5">
        <div class="info flex justify-between text-[16px] font-[Roboto] max-md:hidden max-sm:hidden">
            <select v-if="userStore.id != null" v-model="myCity" @change="selectCity" name="" id="" class="city cursor-pointer outline-none w-[101px]">
                <option v-for="(city, index) in cities" :key="index" :selected="userStore.city" >{{city}}</option>
            </select>
            <select v-else v-model="myCity" @click="toProfile" name="" id="" class="city cursor-pointer outline-none w-[101px]">
                <option v-for="(city, index) in cities" :key="index" :selected="city" >{{city}}</option>
            </select>
            <p class="phone">+7-961-816-85-84</p>
        </div>
        <div class="header-content flex gap-[45px] justufy-between max-md:w-full max-md:justify-between max-md:items-center max-sm:w-full max-sm:gap-[88px] max-sm:items-center">
            <Menu></Menu>
            <img @click="home" src="@public/img/home/header/Logo.svg" class="max-sm:w-[174px] cursor-pointer max-sm:h-full" alt="">
            <SearchMobile></SearchMobile>
            <div class="header-center flex max-md:hidden max-sm:hidden">
                <div class="seacrhCatalog flex gap-[16px]">
                    <Catalog></Catalog>
                    <div class="flex flex-col">
                        <Search></Search>
                    </div>
                </div>
            </div>
            <div class="icons flex gap-[45px] items-center max-md:hidden max-sm:hidden">
                <img @click="toProfile" class="cursor-pointer hover:opacity-85 h-[50px]" src="@public/img/home/header/Male User.svg" alt="">
                <img @click="toFavorite" class="cursor-pointer hover:opacity-85 h-[50px]" src="@public/img/home/header/Heart.svg" alt="">
                <img @click="toCart" class="cursor-pointer hover:opacity-85 h-[50px]" src="@public/img/home/header/Shopping Cart.svg" alt="">
            </div>
        </div>
    </header>
</template>

<script setup>
    import { useRouter } from 'vue-router';
    import Catalog from '../../modals/home/Catalog.vue';
    import Search from '../../modals/home/Search.vue'
    import SearchMobile from '../../modals/home/SearchMobile.vue';
    import Menu from './../../modals/home/Menu.vue'
    import { useUserStore } from '@/store/user-store';
    import { ref } from 'vue';

    const userStore = useUserStore();
    const router = useRouter();
    let cities = ref([
        "Москва", "Санкт-Петербург","Екатринбург","Казань"
    ])
    let myCity = ref([])
    if (myCity.value.length == 0) {
            myCity.value = cities.value[0];
    }

    const selectCity = () => {
        userStore.city = myCity.value
        console.log(userStore.city);
    }
    const home = () => {
        router.push("/")
    }
    const toProfile = () => {
        if (userStore.id == null) {
            router.push("/login")
        }
        else if(userStore.role_id == 1){
            router.push("/admin/orders")
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
