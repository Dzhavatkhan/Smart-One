<template>
    <section class="w-full h-[289px] flex justify-center items-center max-sm:px-0 px-[200px] mt-[19px]">
        <swiper :loop="true" :cssMode="true" :navigation="false" :pagination="{clickable: true}" :mousewheel="true" :keyboard="true" :modules="modules" class="mySwiper">
        <swiper-slide v-for="(item, index) in slider" :key="index" class="w-full flex justify-center">
            <div class="w-full flex justify-center pb-10">
                <img :src="item" alt="">
            </div>
        </swiper-slide>         
    </swiper>
    </section>
</template>

<script setup>
    import { onMounted, ref } from "vue";
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import { FreeMode, Navigation, Thumbs } from 'swiper/modules';

    const thumbsSwiper = ref(null);
    const props = defineProps({
        product: Object,
        slider: Object
    })
    const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
    };
    const modules = [FreeMode, Navigation, Thumbs]

</script>

<style scoped>
    .swiper-pagination-bullet-active {
        background-color: #05DBF2 !important;
    }
        img{
            height: 272px;
            width: 222px;
        }
</style>
