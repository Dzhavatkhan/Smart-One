<template>
    <button @click="show = !show" class="cursor-pointer text-[#1B7A94] w-[131px] duration-300 hover:bg-[#EEFBFE]">Редактировать</button>

    <transition name="fade">
        <div v-show="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[900px] py-5 flex flex-col just gap-3 px-24">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="show = !show; console.log(show)" src="@public/img/admin/Multiply.svg">
                    </div>
                    <div class="title w-full font-bold text-[36px] text-center">
                        Редактировать товар
                    </div>
                    <div class="menu h-full w-full flex flex-col justify-center items-center gap-10">
                        <editProduct :product="product"></editProduct>
                        <productColor :product="product"></productColor>
                        <sliderProduct :product="product"></sliderProduct>
                    </div>
                </div>
            </div>
        </div>
    </transition>

</template>

<script setup>
    import { ref } from "vue";
    import editProduct from "./main/editProduct.vue";
    import productColor from "./color/productColor.vue";
    import sliderProduct from './slider/sliderProduct.vue'

    let show = ref(false);
    const props = defineProps({
        product: Object,
        // Другие props
    });
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.2s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
</style>
