<template>
    <Header></Header>
    <div class=" hidden max-md:w-full max-md:flex max-sm:w-full max-sm:flex flex-col gap-7">
        <div class="title px-5 text-[#4E4C4C] text-[24px] pt-[15px]">Каталог</div>
        <div class="cont w-full" v-for="(block, index) in blocks" :key="index">
            <div class="item  items-center flex px-4 justify-between h-[50px] border-t border-gray-100 w-full bg-white shadow-md">
                <div class="item-info flex gap-[9px] items-center">
                    <img :src="'/img/admin/type/' + block.image" alt="">
                    <router-link :to="{path:'/catalog/' + block.name}" class="category-name">
                        {{ block.name }}
                    </router-link>
                </div>
                <img v-show="block.lists.length > 0" class="down cursor-pointer w-[30px] h-[30px]" @click="getList(block)" :src="block.icons.down" alt="">
            </div>
            <div v-show="block.isShow" class="flex flex-col gap-3">
                <div v-for="list in block.lists" :key="list.id" class="bg-gray-100 h-[50px] pl-[54px] pr-5 flex justify-between items-center">
                    <router-link :to="{path:`/catalog/${block.name}/` + list.name}" class="category">{{list.name}}</router-link>
                    <img src="/public/img/admin/rigth.svg" alt="">
                </div>
            </div>

        </div>
    </div>
    <div class="pc max-md:hidden max-sm:hidden flex flex-col px-[200px] pt-5 gap-5">
        <div class="title text-[36px] text-[#4E4C4C]">Каталог</div>
        <div class="pc w-full flex flex-wrap  gap-[6rem]">
            <div class="flex gap-3" v-for="(block, index) in blocks" :key="index">
                 <div  class="category-image h-full flex justify-center items-start">
                    <img :src="'/img/admin/type/' + block.image" alt="">
                </div>
                <div class="category-item flex flex-col gap-4">
                    <router-link :to="{path: `/catalog/` + block.name}"  class="title font-bold text-[16px] font-[Roboto] flex items-center">{{block.name}}</router-link>
                    <div class="subcategories gap-[10px] flex-col flex" v-show="block.lists.length > 0">
                        <div class="subcategory text-[16px] font-[Roboto]" v-for="list in block.lists" :key="list.id">
                            <router-link :to="{path: `/catalog/${block.name}/` + list.name}">{{ list.name }}</router-link>
                            <!-- :to="{path: `/catalog/${block.name}/` + list.name}" -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <MobileMenu class="hidden max-md:flex max-sm:flex"></MobileMenu>
</template>

<script setup>
    import Header from './../../components/sections/home/Header.vue'
    import Footer from './../../components/sections/home/Footer.vue'
    import MobileMenu from "./../../components/structure/Index.vue"
    import { onMounted, ref } from 'vue';

    let blocks = ref([]);
    let downBtn = "/img/admin/ExpandArrow.svg"
    let createBtn = "/img/admin/Plus Math.svg"

    async function getCategories(){
        let response = await axios.get("/api/getCategories")
        let categories = response.data.categories
        let arr = [];
        for (let category in categories){
            if (!blocks.value.includes(categories[category])) {
                arr.push({
                    id: categories[category].id,
                    image: categories[category].image,
                    name: categories[category].name,
                    lists: categories[category].lists,
                    isShow: false,
                    icons:{
                    down:   downBtn,
                    create: createBtn
                }, selected:false
            },
            )}

        }
        console.log(arr);
        blocks.value = arr;
    }
    function getList(block){

        block.isShow = !block.isShow;
        console.log("getList work")
        if (block.isShow == true) {
            block.icons.down = "/img/admin/Multiply.svg"
        }
        else{
            block.icons.down = "/img/admin/ExpandArrow.svg"
        }

    }

    onMounted(async() => {
        await getCategories();
    })
</script>

<style scoped>

</style>
