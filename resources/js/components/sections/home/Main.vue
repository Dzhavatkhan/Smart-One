<template>
    <main class="w-full max-sm:h-full">
        <AdSlider class="max-sm:hidden"></AdSlider>
        <AdSliderMobile class="hidden max-sm:block"></AdSliderMobile>
        <div class="w-full hidden max-sm:block">
            <CategoryCard></CategoryCard>
        </div>
        <section class="new-products w-full flex flex-col gap-[42px] px-[200px] mb-[52px] max-sm:px-5 max-sm:gap-[24px]">
            <div class="title text-[36px] text-[#4E4C4C] max-sm:text-[24px]">
                Новинки
            </div>
            <div class="np-cont w-full flex gap-[37.95px] max-sm:gap-5 max-sm:flex-wrap">
                <NewProducts></NewProducts>
            </div>
        </section>
        <div class="w-full max-sm:hidden">
            <CategoryCard></CategoryCard>
        </div>
        <section class="new-products w-full flex flex-col gap-[42px] px-[200px] mb-[52px] max-sm:hidden">
            <div class="title text-[36px] text-[#4E4C4C]">
                Популярные товары
            </div>
            <div class="np-cont w-full flex gap-[37.95px] max-sm:gap-5 max-sm:flex-wrap">
                <Product/>
            </div>
        </section>
    </main>
</template>

<script setup>
    import AdSlider from './AdSlider.vue'
    import Product from './Product.vue'
    import NewProducts from './NewProducts.vue'
    import CategoryCard from './CategoryCard.vue'
    import AdSliderMobile from './AdSliderMobile.vue';
</script>

<style scoped>

</style>
