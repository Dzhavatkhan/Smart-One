<template>
    <div class="search w-full px-10 bg-white h-20 shadow rounded-md flex justify-between items-center">
        <div class="search-box bg-[#F0F3F4] h-10 rounded-md flex justify-around px-4">
            <input type="text" placeholder="Поиск" class="bg-transparent outline-none">
            <img class="w-8" src="../../../../../public/img/admin/Search.svg" alt="">
        </div>
        <div class="search-btn flex gap-5">
            <createProduct></createProduct>
            <button @click="deleteCategory" :class="count > 0 ? 'w-20 h-10 rounded-md duration-300 text-[#DE0202] hover:bg-[#FFF0F0]' : 'hidden'">
                Удалить
            </button>
        </div>
    </div>
    <div class="panel-content rounded-md p-10 h-full bg-white shadow flex flex-col gap-5">
        <div class="panel-navbar flex justify-start items-center">
            <div class="text-[32px]" style="font-family: Roboto Condensened">Товары</div>
        </div>
        <table>
            <thead class="border-b-[3px] border-t-[3px] h-[48px]  border-[#F2F4F6]">
                <td class="flex items-center justify-center font-bold">
                    <input type="checkbox" @click="selectAll" v-model="allSelected" class="w-5 h-10 border border-[#F1F2F4]" name="" id="">
                </td>
                <td class="text-center font-bold">
                    Фото
                </td>
                <td class="text-center font-bold">
                    Название
                </td>
                <td class="text-center font-bold">
                    Цвет
                </td>
                <td class="text-center font-bold">
                    Категория
                </td>
                <td class="text-center font-bold">
                    Цена
                </td>
                <td class="text-center font-bold">
                    Дата
                </td>
                <td>

                </td>

            </thead>

            <tbody class="h-auto overflow-auto">
                <tr v-for="product in products" :key="product.id">
                    <td class="text-center">
                        <div class="flex p-1 justify-center items-center">
                            <input type="checkbox" v-model="checkbox" class="w-5 h-5 border border-[#F1F2F4]" name="" id="">
                        </div>
                    </td>
                    <td class="text-center flex justify-center items-center">
                        <div class="image h-[82px] flex justify-center items-center">
                            <img :src="'/img/products/' + product.image" class="img h-auto"  alt="">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="name p-1 text-center overflow-hidden">
                            {{ product.name }}
                        </div>
                    </td>
                    <td class="">
                        <div class="color p-1 text-center">
                           {{ product.color }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="type p-1 text-center">
                            {{ product.typeProduct }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="price p-1 text-center">
                            {{ product.price }}₽
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="date p-1 text-center">
                            {{ product.date }}
                        </div>

                    </td>
                    <td class="text-center"><editProduct :product="product"></editProduct></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'
    import createProduct from '../../modals/admin/products/createProduct.vue'
    import editProduct from "../../modals/admin/products/editProduct/index.vue";

    let count = 0;
    let products = ref([]);
    let allSelected = ref(false)
    let checkbox = ref([]);
    const userStore = useUserStore();
    const props = defineProps({
    })

    async function getProducts(){
        let response = await axios.get("/api/getProducts", {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        products.value = response.data.products

    }


    onMounted(async() => {
        await getProducts();
        eventBus.on('createProduct', async()=>{
            await getProducts();
        })
        eventBus.on('updateProduct', async()=>{
            await getProducts();
        })

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
    thead td{
        padding-top: 10px !important;
        padding-right: 0;
        padding-left: 0;
        padding-bottom: 10px !important;
    }
    thead td{
        border-bottom: #F1F2F4 3px solid;
        border-top: #F1F2F4 3px solid;
    }
    table tr{
        border-top: thin solid;
        border-bottom: thin solid;
    }
    table{
        border-collapse:separate;
        border-spacing:0px 30px;
    }
    .price, .name, .color, .type, .date{
        width: 120px;
    }
</style>
