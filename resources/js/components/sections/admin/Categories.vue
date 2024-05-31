<template>
    <div class="search w-full px-10 bg-white h-20 shadow rounded-md flex justify-between items-center">
        <div class="search-box bg-[#F0F3F4] h-10 rounded-md flex justify-around px-4">
            <input type="text" placeholder="Поиск" class="bg-transparent outline-none">
            <img class="w-8" src="../../../../../public/img/admin/Search.svg" alt="">
        </div>
        <div class="search-btn flex gap-5">

            <createCategory></createCategory>
            <button @click="deleteCategory" :class="count > 0 ? 'w-20 h-10 rounded-md duration-300 text-[#DE0202] hover:bg-[#FFF0F0]' : 'hidden'">
                Удалить
            </button>
        </div>
    </div>
    <div class="panel-content rounded-md p-10 h-full bg-white shadow flex flex-col gap-5">
        <div class="panel-navbar flex justify-start items-center">
            <div class="text-[32px]" style="font-family: Roboto Condensened">Категории</div>
        </div>
        <div id="v-model-select" class="demo">
            <ul class="list flex flex-col gap-5">
                <li class="flex flex-col gap-3" v-for="(block, index) in blocks" :key="index">
                    <div class="shadow border border-t-gray-100 h-14 flex justify-between items-center px-5" >
                        <div class="flex gap-3 items-center">
                            <input type="checkbox" @click="selectCategory(block)" v-model="block.selected" class="w-4" >
                            <img class="h-full w-full" :src="'/img/admin/type/' + block.image" alt="">
                            <p >{{ block.name}}</p>
                        </div>
                        <div class="btns flex gap-3">
                            <createSubcategory :block="block"></createSubcategory>
                            <img v-show="block.lists.length > 0" class="down cursor-pointer w-[30px] h-[30px]" @click="getList(block)" :src="block.icons.down" alt="">
                        </div>
                    </div>
                    <div v-show="block.isShow" v-for="list in block.lists" :key="list.id" class="bg-gray-100 h-12 px-10 flex justify-between items-center">
                        <div class="category">{{list.name}}</div>
                        <div class="operation">Удалить</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import createCategory from "../../modals/admin/categories/createCategory.vue";
    import createSubcategory from '../../modals/admin/categories/createSubcategory.vue'
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'


    const userStore = useUserStore();
    const props = defineProps({
    })
    let createSubcategoryModal = ref(false)
    let downBtn = "/img/admin/ExpandArrow.svg"
    let createBtn = "/img/admin/Plus Math.svg"
    let selectedCategory = [];
    let count = 0;
    let blocks = ref([
        // { id: 1, isShow: false, name: 'Один', icons:{
        //     down:   downBtn,
        //     create: createBtn
        // }, selected:false },
        // { id: 2, isShow: false, name: 'Два', icons:{
        //     down:   downBtn,
        //     create: createBtn
        // }, selected:false },
        // { id: 3, isShow: false, name: 'Три', icons:{
        //     down:   downBtn,
        //     create: createBtn
        // }, selected:false }
    ]);
    let icons= [{
            down:   downBtn,
            create: createBtn
    }]


    async function getCategories(){
        let response = await axios.get("/api/getCategories", {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
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
    function selectCategory(block){
        if (block.selected == true) {
            count = count - 1;
            block.selected = false;
            selectedCategory = selectedCategory.filter(x => x != block.id)
            console.log(selectedCategory);
        }
        else if (block.selected == false) {
            block.selected = true
            console.log("count " + count);
            if (!selectedCategory.includes(block.id)) {
                selectedCategory.push(block.id)
            }
            console.log(selectedCategory);
            count = count + 1;

        }
        console.log("count, block.selected " + count, block.selected);
    }
    onMounted(async() => {
        eventBus.on('createCategory', async()=>{
            await getCategories();
        })
        eventBus.on('createSubcategory', async()=>{
            await getCategories();
        })

        await getCategories();
    })
</script>


<style scoped>
    .down{
        transition: 0.5s;
    }
    .down:hover{
        -webkit-filter: grayscale(0) brightness(0);
        filter: grayscale(0) brightness(0);
    }
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.2s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
</style>
