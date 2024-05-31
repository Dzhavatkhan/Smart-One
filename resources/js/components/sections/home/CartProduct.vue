
<template>
    <Loading v-show="isLoading"></Loading>
    <div v-for="product in cartProducts" :key="product.id" class="product w-[275.05px] max-h-[351px] duration-200 hover:shadow-lg bg-white shadow-md border-t border-gray-200 flex flex-col max-sm:w-[185px] max-sm:h-[274px]">
        <div class="p-image w-full h-[187px] flex justify-center items-center">
            <div class="relative h-[50px] z-10 left-52 bottom-7 max-sm:left-[115px] max-sm:bottom-5">
                <div class="flex flex-col h-full w-full justify-between cursor-pointer">
                    <Heart :product="product"></Heart>
                    <img @click="deleteProductFromCart(product.id)" src="/public/img/home/main/Delete.svg" class="" alt="">
                </div>
            </div>
            <router-link :to="{path: '/product/id' + product.id}"><img class="max-h-full pt-[11px] max-w-[185px] max-sm:pt-[16px] max-sm:w-[85px]" :src="'/img/products/' + product.image" alt=""></router-link>
        </div>
        <div class="p-info gap-[17px] pl-[19px] pr-[12px] w-full h-full flex flex-col max-sm:gap-0 max-sm:justify-between">
            <div class="p-name flex flex-col text-[20px] pt-2 cursor-pointer max-sm:text-[14px]">
                <div v-if="product.avg > 0" class="hidden max-sm:flex w-full h-[17px]">
                    <img src="/public/img/home/mobile/Star.svg" alt="">
                    <div class="revCount text-[14px]">{{product.avg}}</div>
                </div>
                <div v-else class="hidden max-sm:flex w-full h-[17px]">
                    <img src="/public/img/home/mobile/Star.svg" alt="">
                    <div class="revCount text-[14px]">Нет отзывов</div>
                </div>
                <router-link :to="{path: '/product/id' + product.id}" class="font-semibold font font-[Roboto]">{{product.name}}</router-link>
                <p class="font-[Roboto]">{{product.description}},{{product.color}}</p>
            </div>
            <div class="p-price flex justify-between items-center pb-6 max-sm:pb-[9px]">
                <div class="price font-semibold text-[24px] font-[Roboto] max-sm:text-[20px]">{{product.price}}₽</div>
                <button class="w-[87px] h-7 rounded-md duration-300 hover:scale-110 bg-[#05DBF2] font-[Roboto] text-white max-sm:hidden">Купить</button>
                <img src="/public/img/profile/Добавить.svg" alt="" class="addCart hidden max-sm:flex cursor-pointer w-8 h-8 max-sm:w-10 max-sm:h-10">
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import Heart from './Heart.vue';
    import eventBus from '@/eventBus'
    import { useUserStore } from '@/store/user-store';
    import Loading from '../../structure/Loading.vue';
    import Swal from 'sweetalert2';


    let cartProducts = ref([]);
    const userStore = useUserStore();
    let isLoading = ref(true);

    async function getCartProducts(){
        let response = await axios.get("/api/getCart", {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        isLoading = false
        cartProducts.value = response.data.cart;

    }
    async function deleteProductFromCart(id){
        if (userStore.id != null) {
            let response = await axios.get(`/api/deleteProductFromCart/id${id}`, {
                headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
            })
            .then((result) => {
                eventBus.emit('deleteProductFromCart', '')
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
                Swal.fire({
                    title: 'Произошла ошибка!',
                    icon: 'error',
                    toast: true,
                    position: "bottom-right",
                    timer: 3000,
                    showConfirmButton: false,
                    confirmButtonText: false
                })                
            });
        }
        else{
            location.href = "/login"
        }
    }
    onMounted(async() => {
        await getCartProducts();
        eventBus.on('addProductToCart', async()=>{
            await getCartProducts();   
        })
        eventBus.on('deleteProductFromCart', async()=>{
            await getCartProducts();   
        })
        eventBus.on('addProductToFavorite', async()=>{
            await getCartProducts();   
        })
    })

</script>

<style scoped>

</style>