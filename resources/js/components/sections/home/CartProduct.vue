
<template>
    <Loading v-show="isLoading"></Loading>
    <div v-if="cartProducts.length != 0" class="vIF w-full h-full gap-[38.07px] max-sm:gap-x-0 max-md:gap-x-5 max-md:gap-y-5 max-sm:gap-y-5 max-sm:justify-between flex flex-wrap ">
        <div  v-for="product in cartProducts" :key="product.id" class="product w-[275.05px] max-h-[351px] duration-200 hover:shadow-lg bg-white shadow-md border-t border-gray-200 flex flex-col max-sm:w-[185px] max-sm:h-[274px] max-[400px]:h-[247px] max-[400px]:w-[168px]">
            <div class="p-image w-full min-h-[186px] max-md:min-h-[155px] max-sm:min-h-[98px] flex justify-center items-center">
                <img @click="getProduct(product.id)" class="max-h-full pt-[11px] max-w-[185px] max-md:pt-[16px] max-md:w-[96px] max-sm:pt-[16px] max-sm:w-[85px] max-[400px]:w-[75px] max-[400px]:max-h-[88px]" :src="'/img/products/' + product.image" alt="">
                <div class="relative w-[20px] h-[50px] left-[20px] z-10 bottom-10  max-sm:m-0 max-sm:left-[15px] max-sm:bottom-1 max-md:m-0 max-md:left-[65px] max-md:bottom-5">
                    <div class="flex flex-col h-full w-full justify-between cursor-pointer">
                        <Heart :product="product"></Heart>
                        <img @click="deleteProductFromCart(product.id)" src="@public/img/home/main/Delete.svg" class="" alt="">
                    </div>
                </div>
            </div>
            <div class="p-info justify-between pl-[19px] pr-[12px] w-full h-full flex flex-col max-md:gap-0 max-md:justify-between max-sm:gap-0 max-sm:justify-between">
                <div class="p-name flex flex-col text-[20px] pt-2 max-[400px]:text-[12px] cursor-pointer max-md:text-[14px] max-sm:text-[14px]">
                    <div v-if="product.avg > 0" class="hidden mb-[5px] max-sm:flex max-md:flex w-full h-[17px]">
                        <img src="@public/img/home/mobile/Star.svg" alt="">
                        <div class="revCount max-[400px]:text-[12px] text-[14px]">{{product.avg}}</div>
                    </div>
                    <div v-else class="hidden mb-[5px] max-sm:flex max-md:flex w-full h-[17px]">
                        <img src="@public/img/home/mobile/StarEmpty.svg" alt="">
                        <div class="revCount max-[400px]:text-[12px] text-[14px]">0</div>
                    </div>
                    <div class="name max-[400px]:text-[12px] text-[20px] max-sm:text-[14px]">
                        <router-link :to="{path: '/product/id' + product.id}" class="font-semibold font-[Roboto]">
                            {{product.name}}
                        </router-link>
                        {{product.description}}, {{product.color}}
                    </div>
                </div>
                <div class="p-price flex justify-between items-center pb-6 max-md:pb-[9px] max-sm:pb-[9px]">
                    <div class="price font-semibold text-[24px]  max-[400px]:text-[16px] font-[Roboto] max-md:text-[20px] max-sm:text-[20px]">{{product.price}}₽</div>
                    <BuyBtn :product="product.id"></BuyBtn>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="vElse w-full h-[133px] flex justify-center items-center">
        <div class="w-max h-max">
            Корзина пуста.
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
    import BuyBtn from './BuyBtn.vue';


    let cartProducts = ref([]);
    const userStore = useUserStore();
    let isLoading = ref(true);

    function getProduct(id){
        location.href = `/product/id${id}`
    }
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