<template>
    <div v-show="isLoading" class="w-full h-full flex justify-center items-center">
        <Loading></Loading>
    </div>

    <div v-for="product in products" :key="product.id" class="new-product w-[275.05px] h-[351px] duration-200 hover:shadow-lg bg-white shadow-md border-t border-gray-200 flex flex-col max-sm:pt-4 max-sm:w-[185px] max-sm:h-[274px]">
        <div class="np-image w-full h-[187px] flex justify-center items-center ">
            <Heart class="relative left-52 bottom-7 max-sm:left-[115px] max-sm:bottom-7" :product="product"></Heart>
            <img class="max-h-full pt-[11px] max-w-[185px] max-sm:pt-[16px] max-sm:w-[85px] max-sm:h-[98px] max-sm:p-0" :src="'/img/products/' + product.image" alt="">
        </div>
        <div class="np-info gap-[17px] pl-[19px] pr-[12px] w-full h-full flex flex-col max-sm:pl-2 max-sm:pr-[7px] max-sm:gap-[30px]">
            <div class="np-name flex flex-col text-[20px] pt-2 cursor-pointer  max-sm:text-[14px] max-sm:h-[70px]">
                <div class="hidden max-sm:flex w-full h-[17px]">
                    <img src="/public/img/home/mobile/Star.svg" alt="">
                    <div class="revCount text-[14px]">5</div>
                </div>
                <router-link :to="{path: '/product/id' + product.id}" class="font-semibold font font-[Roboto]">{{product.name}}</router-link>
                <p class="font-[Roboto]">{{product.description}}, {{product.color}}</p>
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
        eventBus.on('addProductToFavorite', async()=>{
            await getNewProducts();   
        })         
    })
</script>

<style scoped>

</style>