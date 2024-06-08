<template>
    <main class="w-full max-md:h-full max-sm:h-full">
        <AdSlider class="max-sm:hidden max-md:hidden"></AdSlider>
        <AdSliderMobile class="hidden max-md:block max-sm:block"></AdSliderMobile>
        <div class="w-full hidden max-md:block max-sm:block">
            <CategoryCard></CategoryCard>
        </div>
        <section class="new-products w-full flex flex-col gap-[42px] px-[200px] mb-[52px] max-sm:px-5 max-sm:gap-[24px] max-md:px-5 max-md:gap-[24px]">
            <div class="title text-[36px] text-[#4E4C4C] max-sm:text-[24px]">
                Новинки
            </div>
            <div class="np-cont w-full flex gap-[37.95px] max-md:gap-5 max-sm:gap-5 max-md:flex-wrap max-sm:flex-wrap">
                <NewProducts></NewProducts>
            </div>
        </section>
        <div class="w-full max-md:hidden max-sm:hidden">
            <CategoryCard></CategoryCard>
        </div>
        <section class="new-products w-full flex flex-col gap-[42px] px-[200px] mb-[52px] max-md:hidden max-sm:hidden">
            <div class="title text-[36px] text-[#4E4C4C]">
                Популярные товары
            </div>
            <div class="np-cont w-full flex gap-[37.95px] max-sm:gap-5 max-md:flex max-sm:flex-wrap">
                <PopularProducts/>
            </div>
        </section>
    </main>
</template>

<script setup>
    import AdSlider from './AdSlider.vue'
    import NewProducts from './NewProducts.vue'
    import CategoryCard from './CategoryCard.vue'
    import AdSliderMobile from './AdSliderMobile.vue';
    import PopularProducts from './PopularProducts.vue';
</script>

<style scoped>

</style>
