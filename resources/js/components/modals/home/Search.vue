<template>
        <div class="flex h-[55px] w-[819px] border border-[#162C40]">
            <div  @click="show = !show" class="searchCategory cursor-pointer duration-300 hover:opacity-75 hover:text-black font-[Roboto] gap-[12px] text-[#797171] bg-[#F5F7FA] h-full w-[105px] flex justify-center items-center">
                <div class="category">Все</div>
                <img src="@public/img/home/header/DoubleDown.svg" alt="">
            </div>
            <div class="searchInput w-full flex items-center px-[53px]">
                <input @input="search" v-model="searchQuery"  type="text" class="placeholder:text-[#797171] w-full outline-none" placeholder="Поиск...">
            </div>
            <img src="@public/img/home/header/Search.svg" class="cursor-pointer duration-300 hover:opacity-90" alt="" srcset="">
        </div>
        <div ref="searchDiv" class="bg-white absolute top-52 result z-20 hidden shadow-md max-w-[1200px] max-h-96">
            <div v-if="results.categories == 0 && results.products == 0" class="w-full py-5 h-full flex flex-col">
                <div class="Noresult h-full flex w-full justify-center items-center">Ничего не найдено.</div>
            </div>
            <div v-else class="w-full h-full flex flex-col gap-2 justify-between">
                <div v-for="product in results.products" :key="product.id" class="Noresult py-5 h-full flex items-center duration-300 hover:bg-gray-100 cursor-pointer gap-4 px-10 w-full">
                    <router-link :to="{path: '/product/id' + product.id}" class="w-10 h-10"><img :src="'/img/products/' + product.image" alt="" class="productImg w-full h-full"></router-link>
                    <router-link :to="{path:'/product/id' + product.id}" class="cursor-pointer">{{product.name}}</router-link>
                </div>
                <div v-for="category in results.categories" :key="category.id" class="Noresult py-5 h-full flex items-center w-full duration-300 hover:bg-gray-100 cursor-pointe gap-4 px-10">
                    <router-link :to="{path:'/catalog/' + category.name}" class="w-10 h-10">
                        <img :src="'/img/admin/type/' + category.image" class="w-full h-full" alt="">
                    </router-link>
                    <router-link :to="{path:'/catalog/' + category.name}" class="cursor-pointer">
                        {{ category.name }}
                    </router-link>
                </div>                
            </div>            
        </div>
        <transition name="fade">
            <div class="catalog fixed inset-0 m-auto bg-black bg-opacity-60 z-20" v-show="show">
                <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                    <div class="bg-white shadow-md w-[1541px] h-[798px] px-9 flex gap-[58px]">
                        <div class="categories flex flex-col gap-[72px]">
                            <div class="category title text-start pt-[61px] text-[36px]">
                                Каталог
                            </div>
                            <div class="categories flex flex-col gap-[26px]">
                                <div class="category flex gap-[2px]">
                                    <img src="@public/img/home/header/iPhone 14.svg" alt="">
                                    <div @click="active" class="category-name text-[32px] text-[#4E4C4C] active font-[Roboto]">Смартфоны</div>
                                </div>
                                <div class="category flex gap-[2px]">
                                    <img src="@public/img/home/header/iPad.svg" alt="">
                                    <div @click="active" class="category-name text-[32px] font-[Roboto]">Планшеты</div>
                                </div>
                                <div class="category flex gap-[2px]">
                                    <img src="@public/img/home/header/Laptop.svg" alt="">
                                    <div @click="active" class="category-name text-[32px] text-[#4E4C4C] font-[Roboto]">Ноутбуки</div>
                                </div>
                                <div class="category flex gap-[2px]">
                                    <img src="@public/img/home/header/Earbud Headphones.svg" alt="">
                                    <div @click="active" class="category-name text-[32px] text-[#4E4C4C] font-[Roboto]">Наушники</div>
                                </div>
                                <div class="category flex gap-[2px]">
                                    <img src="@public/img/home/header/Smart Watch.svg" alt="">
                                    <div @click="active" class="category-name text-[32px] text-[#4E4C4C] font-[Roboto]">Смарт-часы</div>
                                </div>
                                <div class="category flex gap-[2px]">
                                    <img src="@public/img/home/header/USB C.svg" alt="">
                                    <div @click="active" class="category-name text-[32px] text-[#4E4C4C] font-[Roboto]">Аксессуары</div>
                                </div>
                            </div>
                        </div>
                        <div v-for="category in categories" :key="category.id" class="content w-4/5 flex gap-8">
                            <div class="w-[5px] h-full bg-[#05DBF2]"></div>
                                <div class="subcategories w-full flex flex-col gap-[79px]">
                                    <div class="category-name w-full flex justify-between font-[Roboto] title text-[32px] pt-[63px]">
                                        <div class="">{{category.name}}</div>
                                        <img class="close text-right cursor-pointer w-[20px]" @click="show = !show" src="@public/img/admin/Multiply.svg">
                                    </div>
                                    <div class="subc-cont w-full flex flex-wrap gap-[66px]">
                                        <div class="content flex flex-col gap-[25px]">
                                            <router-link :to="{path:'/catalog/' + category.name}" class="category-name cursor-pointer opacity-75 font-semibold title text-[24px]">
                                                {{category.name}}
                                            </router-link>
                                            <div v-for="subcategory in categories[0].lists" :key="subcategory.id" class="sub-list flex flex-col gap-[37px]">
                                                <router-link :to="{path:`/catalog/${category.name}/` + subcategory.name}" class="list_item opacity-75 font-[Roboto] text-[20px]">
                                                    {{ subcategory.name }}
                                                </router-link>
                                            </div>
                                        </div>
    
                                    </div>
    
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </transition>

</template>

<script setup>
    import { onMounted, ref } from "vue";
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();
    let show = ref(false);
    let searchDiv = ref([]);
    let query = ref([]);
    let searchQuery = ref([]);
    let categories = ref([]);
    let results = ref([])

    function active(e){
        console.log(e.target.textContent);
        let lastActive = document.querySelector(".active");
        if (e.target == lastActive) {
             query.value = e.target.textContent
        }
        else{
            lastActive.classList.toggle("active")
            e.target.classList.toggle("active");
            query.value = e.target.textContent
        }

        getTab();
    }
    async function getTab(){
        if (query.value.length == 0) {
            query.value = document.querySelector(".active").textContent
            console.log(document.querySelector(".active").textContent);
        }
        console.log(query.value);
        let response = await axios.get(`/api/catalog/category=${query.value}`)
        console.log(response.data.catalog);
        categories.value = response.data.catalog
    }
    async function search(){
        if (searchQuery.value ==  null || searchQuery.value.length == 0) {
            searchDiv.value.classList.add("hidden")
            console.log("null");
        }
        else{
            searchDiv.value.classList.remove("hidden")
            let response = await axios.get(`/api/search=${searchQuery.value}`)
            console.log(response.data.results.categories, response.data.results.products);
            results.value = response.data.results
        }
    }
    onMounted(async() => {
        await getTab();
    })
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

