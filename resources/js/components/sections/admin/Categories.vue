<template>
    <div class="search w-full px-10 bg-white h-20 shadow rounded-md flex justify-between items-center">
        <div class="search-box bg-[#F0F3F4] h-10 rounded-md flex justify-around px-4">
            <input type="text" placeholder="Поиск" class="bg-transparent outline-none">
            <img class="w-8" src="../../../../../public/img/admin/Search.svg" alt="">
        </div>
        <div class="search-btn flex gap-5">

            <createCategory></createCategory>
            <button @click="deleteCategories(selectedCategory)" :class="count > 0 ? 'w-20 h-10 rounded-md duration-300 text-[#DE0202] hover:bg-[#FFF0F0]' : 'hidden'">
                Удалить
            </button>
        </div>
    </div>
    <div class="panel-content overflow-auto rounded-md p-10 h-full bg-white shadow flex flex-col gap-5">
        <div class="panel-navbar flex justify-between items-center">
            <div class="text-[32px]" style="font-family: Roboto Condensened">Категории</div>
            <div class="count text-[24px]">
                {{ blocks.length }}
            </div>
        </div>
        <div id="v-model-select" class="demo">
            <ul class="list flex flex-col gap-5">
                <li class="flex flex-col gap-3" v-for="(block, index) in blocks" :key="index">
                    <div class="shadow border border-t-gray-100 h-14 flex justify-between items-center px-5" >
                        <div class="flex gap-3 items-center">
                            <input type="checkbox" @click="selectCategory(block)" v-model="block.selected" class="w-4" >
                            <img class="h-[33px] w-[33px]" :src="'/img/admin/type/' + block.image" alt="">
                            <p >{{ block.name}}</p>
                        </div>
                        <div class="btns flex items-center gap-3">
                            <createSubcategory :block="block"></createSubcategory>
                            <img @click="deleteCategory(block.id)" class="h-full cursor-pointer" src="/public/img/home/main/Delete.svg" alt="">
                            <img v-show="block.lists.length > 0" class="down cursor-pointer w-[30px] h-[30px]" @click="getList(block)" :src="block.icons.down" alt="">
                        </div>
                    </div>
                    <div v-show="block.isShow" v-for="list in block.lists" :key="list.id" class="bg-gray-100 h-12 px-10 flex justify-between items-center">
                        <div class="category">{{list.name}}</div>
                        <div @click="deleteSubcategory(list.id)" class="operation cursor-pointer duration-300 hover:text-[red]">Удалить</div>
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
    import axios from "axios";
    import Swal from "sweetalert2";


    const userStore = useUserStore();
    const props = defineProps({
    })
    let createSubcategoryModal = ref(false)
    let downBtn = "/img/admin/ExpandArrow.svg"
    let createBtn = "/img/admin/Plus Math.svg"
    let selectedCategory = [];
    let count = 0;
    let blocks = ref([]);
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
    async function deleteCategories(categories){
        for (let index = 0; index < categories.length; index++) {
            const id = categories[index];
            let response = await axios.delete(`/api/deleteTypeProduct/id${id}`, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            eventBus.emit('deleteCategories', '')   
            count = count - 1               
        }).catch((err) => {
            
        });
           
        }
   
    }
    async function deleteCategory(id){
        let response = await axios.delete(`/api/deleteTypeProduct/id${id}`, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            eventBus.emit('deleteCategory', '')
            Swal.fire({
                title: `${result.data.message}`,
                icon: 'success',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
            })            
        }).catch((err) => {
            console.log(err.response.data);
        });
    }
    async function deleteSubcategory(id){
        let response = await axios.delete(`/api/deleteCategory/id${id}`, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            eventBus.emit('deleteSubcategory', '')
            Swal.fire({
                title: `${result.data.message}`,
                icon: 'success',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
            })            
        }).catch((err) => {
            console.log(err.response.data);
        });
    }

    onMounted(async() => {
        eventBus.on('createCategory', async()=>{
            await getCategories();
        })
        eventBus.on('createSubcategory', async()=>{
            await getCategories();
        })
        eventBus.on('deleteSubcategory', async()=>{
            await getCategories();
        })
        eventBus.on('deleteCategory', async()=>{
            await getCategories();
        })
        eventBus.on('deleteCategories', async()=>{
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
    .panel-content::-webkit-scrollbar {
        width: 5px; /* Ширина всего элемента навигации */
        padding: 2px;

    }

      
    .panel-content::-webkit-scrollbar-track {
        background: #fff; /* Цвет дорожки */
    }
      
    .panel-content::-webkit-scrollbar-thumb {
        padding: 2px;
        cursor: pointer;
        transition: 0.5s;
        background-color: #050c26; /* Цвет бегунка */
        border-radius: 20px; /* Округление бегунка */
        border: 3px solid #050c26; /* Оформление границ бегунка */
    }    
    .panel-content::-webkit-scrollbar-thumb:hover {
        transform: scale(1.1)
    }
</style>
