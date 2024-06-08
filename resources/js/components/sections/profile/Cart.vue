<template>
    <div class="flex flex-col gap-[30px]">
        <div class="hidden max-md:flex max-sm:flex w-full justify-start title text-[28px] text-[#4e4c4c]" >Корзина</div>
        <div class="cont flex h-full w-full flex-wrap gap-[37.73px] max-md:gap-5 max-sm:gap-5">
            <CartProduct></CartProduct>
        </div>
    </div>
</template>

<script setup>
    import CartProduct from '../../sections/home/CartProduct.vue'

</script>

<style scoped>

</style>