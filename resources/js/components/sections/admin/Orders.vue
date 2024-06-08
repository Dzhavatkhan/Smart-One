<template>
    <div class="search w-full px-10 bg-white h-20 shadow rounded-md flex justify-between items-center">
        <div class="search-box bg-[#F0F3F4] h-10 rounded-md flex justify-around px-4">
            <input type="text" placeholder="Поиск" class="bg-transparent outline-none">
            <img class="w-8" src="../../../../../public/img/admin/Search.svg" alt="">
        </div>
        <div class="search-btn flex gap-5">
            <button @click="deleteCategory" :class="count > 0 ? 'w-20 h-10 rounded-md duration-300 text-[#DE0202] hover:bg-[#FFF0F0]' : 'hidden'">
                Удалить
            </button>
        </div>
    </div>
    <div class="panel-content overflow-auto rounded-md p-10 h-full bg-white shadow flex flex-col gap-5">
        <div class="panel-navbar flex justify-between items-center">
            <div class="text-[32px]" style="font-family: Roboto Condensened">Заказы</div>
            <div class="count text-[24px]">{{ orders.length }}</div>
        </div>
        <table>
            <thead class="border-b-[3px] border-t-[3px] h-[48px]  border-[#F2F4F6]">
                <td class="flex items-center justify-center font-bold">
                    Почтовый индекс
                </td>
                <td class="text-center font-bold">
                    Название
                </td>
                <td class="text-center font-bold">
                    Покупатель
                </td>
                <td class="text-center font-bold">
                    Цена
                </td>
                <td class="text-center font-bold">
                    Дата
                </td>

            </thead>

            <tbody class="h-auto overflow-auto">
                <tr v-for="order in orders" :key="order.id">
                    <td class="text-center">
                        {{ order.postIndex }}
                    </td>
                    <td class="text-center">
                        <div class="name p-1 text-center overflow-hidden">
                            {{ order.product }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="type p-1 text-center">
                            {{ order.user.name }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="price p-1 text-center">
                            {{ order.price }}₽
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="date p-1 text-center">
                            {{ order.created_at }}
                        </div>

                    </td>
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
    let orders = ref([]);
    let allSelected = ref(false)
    let checkbox = ref([]);
    const userStore = useUserStore();
    const props = defineProps({
    })

    async function getProducts(){
        let response = await axios.get("/api/getOrders", {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        orders.value = response.data.orders

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
