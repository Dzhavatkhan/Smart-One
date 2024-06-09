<template>
    <div class="w-screen max-[400px]:px-3 px-5 h-[70px] justify-between gap-3 items-center bg-white shadow-menu fixed bottom-0 z-20">
        <router-link class="flex flex-col items-center" to="/">
            <img class="icon" src="@public/img/home/mobile/home.svg" alt="home">
            <div class="home">Главная</div>
        </router-link>
        <router-link class="flex flex-col items-center" to="/catalog">
            <img class="icon" src="@public/img/home/mobile/catalog.svg" alt="home">
            <div class="home">Каталог</div>
        </router-link>
        <router-link  v-if="userStore.id != null" class="flex flex-col items-center" to="/login">
            <img class="icon" src="@public/img/home/mobile/Shopping Cart (1).svg" alt="home">
            <div class="home">Корзина</div>
        </router-link>
        <router-link v-else class="flex flex-col items-center" to="/profile/cart">
            <img class="icon" src="@public/img/home/mobile/Shopping Cart (1).svg" alt="home">
            <div class="home">Корзина</div>
        </router-link>
        <router-link v-if="userStore.id != null" class="flex flex-col items-center" to="/login">
            <img class="icon" src="@public/img/home/mobile/Heart (1).svg" alt="home">
            <div class="home">Избранное</div>
        </router-link>
        <router-link v-else class="flex flex-col items-center" to="/profile/favorite">
            <img class="icon" src="@public/img/home/mobile/Heart (1).svg" alt="home">
            <div class="home">Избранное</div>
        </router-link>
        <router-link v-if="userStore.id != null" class="flex flex-col items-center" to="/profile/me">
            <img class="icon filter fill-black" src="@public/img/home/mobile/Male User (1).svg" alt="home">
            <div class="home">Профиль</div>
        </router-link>
        <router-link v-else class="flex flex-col items-center" to="/login">
            <img class="icon filter fill-black" src="@public/img/home/mobile/Male User (1).svg" alt="home">
            <div class="home">Профиль</div>
        </router-link>

    </div>
</template>

<script setup>
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();
</script>

<style scoped>

    .router-link-active .icon {
        filter: invert(79%) sepia(75%) saturate(3059%) hue-rotate(136deg) brightness(96%) contrast(99%);
    }
    div{
        font-family: "Roboto";
        font-size: 16px;
    }

</style>
