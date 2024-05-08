<template>
    <div class="bg-[#B5C2CA] w-full h-screen flex gap-10 justify-center items-center">
        <div class="navbar bg-[#F0F3F4] w-96 h-[800px] shadow rounded-md">
            <div class="logo text-[#151528] text-[48px] font-[Poppins] px-4">
                smart one
            </div>
            <div class="lane  px-4 h-[2px] w-full">
                <div class="l bg-[#D6DDE2] w-full h-full"></div>
            </div>
            <div class="links flex flex-col h-[700px] justify-between">
                <nav class="nav flex flex-col gap-3 px-4 py-5">
                    <router-link to="/admin/orders" class="nav-link p-5 rounded-lg hover:bg-[#081225] hover:text-white duration-300 cursor-pointer w-full h-8 flex gap-2 items-center">
                        <img src="../../../../public/img/admin/Expensive Price.svg" alt="">
                        <p>Заказы</p>
                    </router-link>
                    <router-link to="/admin/products" class="nav-link p-5 rounded-lg hover:bg-[#081225] hover:text-white duration-300 cursor-pointer w-full h-8 flex gap-2 items-center">
                        <img src="../../../../public/img/admin/Shopping Basket.svg" alt="">
                        <p>Товары</p>
                    </router-link>
                    <router-link to="/admin/users" class="nav-link p-5 rounded-lg hover:bg-[#081225] hover:text-white duration-300 cursor-pointer w-full h-8 flex gap-2 items-center">
                        <img src="../../../../public/img/admin/User Male.svg" alt="">
                        <p>Клиенты</p>
                    </router-link>
                    <router-link to="/admin/categories" class="nav-link p-5 rounded-lg hover:bg-[#081225] hover:text-white duration-300 cursor-pointer w-full h-8 flex gap-2 items-center">
                        <img src="../../../../public/img/admin/Sorting.svg" alt="">
                        <p>Категории</p>
                    </router-link>
                </nav>
                <div class="admin flex flex-col items-center">
                    <img src="" alt="">
                    <p>name</p>
                </div>
            </div>

        </div>
        <div class="panel px-4 w-[900px] h-[800px] flex flex-col gap-5">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
    .nav-link:hover img{
        -webkit-filter: grayscale(100) brightness(200);
        filter: grayscale(100) brightness(200);
    }
    .router-link-active {
        background-color: #081225;
        color: white;
    }
    .router-link-active img{
        -webkit-filter: grayscale(100) brightness(200);
        filter: grayscale(100) brightness(200);
    }
</style>
