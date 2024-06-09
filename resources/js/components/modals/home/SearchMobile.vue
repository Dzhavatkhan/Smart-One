<template>
    <img @click="show = !show" src="@public/img/home/header/SearchMobile.svg" alt="" class="hidden min-[400px]:w-3 min-[400px]:h-3 max-md:flex max-md:h-5 max-sm:flex max-sm:w-5 max-sm:h-5">

    <transition name="fade">
        <div v-if="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-30 flex justify-center items-center">
                <div class="bg-white shadow-md w-screen h-full px-5 py-5 flex flex-col just gap-6">
                    <div class="img flex w-full justify-between">
                        <input type="text"  @input="search" v-model="searchQuery" class="border-b w-full  outline-none focus:border-black text-[20px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Поиск">
                        <img class="close down text-right cursor-pointer w-[20px]" @click="show = !show" src="@public/img/admin/Multiply.svg">
                    </div>
                    <div class="results h-full w-full">
                        <div v-if="results.categories == 0 && results.products == 0" class="w-full py-5 h-full flex flex-col">
                            <div class="Noresult h-full flex w-full justify-center items-center">Ничего не найдено.</div>
                        </div>
                        <div v-else class="w-full h-full flex flex-col gap-10">
                            <div v-for="product in results.products" :key="product.id" class="Product py-2 h-max border-t border-b border-gray-200 flex items-center duration-300 hover:bg-gray-100 cursor-pointer gap-4 px-10 w-full">
                                <router-link :to="{path: '/product/id' + product.id}" class="w-10 h-10"><img :src="'/img/products/' + product.image" alt="" class="productImg w-full h-full"></router-link>
                                <router-link :to="{path:'/product/id' + product.id}" class="cursor-pointer">{{product.name}}</router-link>
                            </div>
                            <div v-for="category in results.categories" :key="category.id" class="Category py-2 h-max border-t border-b border-gray-200 flex items-center w-full duration-300 hover:bg-gray-100 cursor-pointe gap-4 px-10">
                                <router-link :to="{path:'/catalog/' + category.name}" class="w-10 h-10">
                                    <img :src="'/img/admin/type/' + category.image" class="w-full h-full" alt="">
                                </router-link>
                                <router-link :to="{path:'/catalog/' + category.name}" class="cursor-pointer">
                                    {{ category.name }}
                                </router-link>
                            </div>                
                        </div>  
                    </div>
                </div>
            </div>
        </div>

    </transition>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    let show = ref(false);
    let query = ref([]);
    let searchQuery = ref([]);
    let categories = ref([]);
    let results = ref([])


    async function search(){
        if (searchQuery.value ==  null || searchQuery.value.length == 0) {
            console.log("null");
        }
        else{
            let response = await axios.get(`/api/search=${searchQuery.value}`)
            console.log(response.data.results.categories, response.data.results.products);
            results.value = response.data.results
        }
    }

</script>

<style scoped>
    .category-name{
        cursor: pointer;
    }
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.2s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
    .active{
        color: black;
        font-weight: 600;
    }
    .search{
        height: 100px;
    }
</style>
