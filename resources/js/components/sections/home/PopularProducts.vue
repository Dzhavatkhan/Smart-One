<template>
    <div v-show="isLoading" class="w-full h-full flex justify-center items-center">
        <Loading></Loading>
    </div>

    <div v-for="product in products" :key="product.id" class="new-product w-[275.05px] h-[351px] duration-200 hover:shadow-lg bg-white shadow-md border-t border-gray-200 flex flex-col max-sm:pt-4 max-sm:w-[185px] max-sm:h-[274px]">
        <div class="np-image w-full min-h-[186px] flex justify-center items-center max-sm:min-h-[98px]">
            <img @click="getProduct(product.id)" class="max-h-full cursor-pointer pt-[11px] max-w-[185px] max-sm:w-[85px] max-sm:max-h-[98px] max-sm:p-0" :src="'/img/products/' + product.image" alt="">
            <Heart class="relative left-[20px] bottom-12 max-sm:left-[15px] max-sm:bottom-5" :product="product"></Heart>
        </div>
        <div class="np-info justify-between pl-[19px] pr-[12px] w-full h-full flex flex-col max-sm:pl-2 max-sm:pr-[7px] max-sm:gap-[30px]">
            <div class="np-name flex flex-col text-[20px] pt-2 cursor-pointer  max-sm:text-[14px] max-sm:h-[70px]">
                <div v-if="product.avg > 0" class="hidden max-sm:flex w-full h-[17px]">
                    <img src="@public/img/home/mobile/Star.svg" alt="">
                    <div class="revCount text-[14px]">{{product.avg}}</div>
                </div>
                <div v-else class="hidden max-sm:flex w-full h-[17px]">
                    <img src="@public/img/home/mobile/StarEmpty.svg" alt="">
                    <div class="revCount text-[14px]">0</div>
                </div>
                <div class="name text-[20px] max-sm:text-[14px]">
                    <router-link :to="{path: '/product/id' + product.id}" class="font-semibold font-[Roboto]">
                        {{product.name}}
                    </router-link>
                    {{product.description}}, {{product.color}}
                </div>


            </div>
            <div class="np-price flex justify-between items-center pb-[9px]">
                <div class="price font-semibold text-[24px] font-[Roboto] max-sm:text-[20px]">{{product.price}}₽</div>
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


    let products = ref([]);
    let isLoading = ref(true)

    async function getPopularProducts(){
        let response = await axios.get("/api/getPopularProducts");
        products.value = response.data.products
        isLoading.value = false;
        console.log(products.value);
    }
    function getProduct(id){
        location.href = `/product/id${id}`
    }

    onMounted(async() => {
        await getPopularProducts();
        eventBus.on('addProductToCart', async()=>{
            await getPopularProducts();   
        })   
        eventBus.on('favorite', async()=>{
            await getPopularProducts();   
        })  
     
    })
</script>

<style scoped>

</style>