<template>
    <div class="flex flex-col gap-[30px]">
        <div class="hidden max-sm:flex w-full justify-start title text-[28px] text-[#4e4c4c]" >Избранное</div>
        <div class="cont flex h-full w-full flex-wrap gap-[37.73px] max-sm:gap-5">
            <FavProduct></FavProduct>
        </div>
    </div>

</template>

<script setup>
    import FavProduct from './../home/FavProduct.vue'
</script>

<style lang="scss" scoped>

</style>
