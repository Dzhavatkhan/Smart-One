<template>
    <div v-show="isLoading" class="w-full h-full flex justify-center items-center">
        <Loading></Loading>
    </div>

    <div v-for="product in products" :key="product.id" class="new-product w-[275.05px] h-[351px] duration-200 hover:shadow-lg bg-white shadow-md border-t border-gray-200 flex flex-col max-[400px]:h-[247px] max-[400px]:w-[168px] max-sm:pt-4 max-sm:w-[185px] max-sm:h-[274px] max-md:pt-4 max-md:w-[190px] max-md:h-[294px]">
        <div class="np-image w-full min-h-[186px] flex justify-center items-center max-md:min-h-[98px] max-sm:min-h-[98px]">
            <img @click="getProduct(product.id)" class="max-h-full cursor-pointer pt-[11px] max-[400px]:w-[75px] max-[400px]:max-h-[88px] max-w-[185px] max-sm:w-[85px] max-sm:max-h-[98px] max-sm:p-0" :src="'/img/products/' + product.image" alt="">
            <Heart class="relative left-[20px] bottom-12 max-md:left-[30px] max-sm:left-[30px] max-sm:bottom-5 max-md:bottom-5" :product="product"></Heart>
        </div>
        <div class="np-info justify-between pl-[19px] pr-[12px] w-full h-full flex flex-col max-sm:pl-2 max-sm:pr-[7px] max-sm:gap-[30px] max-md:pl-2 max-md:pr-[7px] max-md:gap-[30px]">
            <div class="np-name flex flex-col text-[20px] pt-2 cursor-pointer max-[400px]:text-[12px] max-md:text-[14px] max-md:h-[70px]  max-sm:text-[14px] max-sm:h-[70px]">
                <div v-if="product.avg > 0" class="hidden max-md:flex max-sm:flex w-full h-[17px]">
                    <img src="@public/img/home/mobile/Star.svg" alt="">
                    <div class="revCount max-[400px]:text-[12px] text-[14px]">{{product.avg}}</div>
                </div>
                <div v-else class="hidden max-md:flex max-sm:flex w-full h-[17px]">
                    <img src="@public/img/home/mobile/StarEmpty.svg" alt="">
                    <div class="revCount max-[400px]:text-[12px] text-[14px]">0</div>
                </div>
                <div class="name text-[20px] max-md:text-[14px] max-sm:text-[14px]">
                    <router-link :to="{path: '/product/id' + product.id}" class="font-semibold font-[Roboto]">
                        {{product.name}}
                    </router-link>
                    {{product.description}}, {{product.color}}
                </div>


            </div>
            <div class="np-price flex justify-between items-center pb-[9px]">
                <div class="price font-semibold text-[24px] font-[Roboto] max-[400px]:text-[16px] max-md:text-[20px] max-sm:text-[20px]">{{product.price}}₽</div>
                <CartBtn :product="product"></CartBtn>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted, ref } from "vue";
    import Heart from "../home/Heart.vue";
    import CartBtn from "./CartBtn.vue";
    import eventBus from '@/eventBus'
    import Loading from "../../structure/Loading.vue";
    import Swal from 'sweetalert2';
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();
    let products = ref([]);
    let isLoading = ref(true)

    function getProduct(id){
        location.href = `/product/id${id}`
    }
    async function getNewProducts(){
        let response = await axios.get("/api/getNewProducts");
        products.value = response.data.products
        isLoading.value = false;
        console.log(products.value);
    }   

    onMounted(async() => {
        await getNewProducts();
        eventBus.on('addProductToCart', async()=>{
            await getNewProducts();   
        })   
        eventBus.on('favorite', async()=>{
            await getNewProducts();   
        })  
       
    })
</script>

<style scoped>

</style>