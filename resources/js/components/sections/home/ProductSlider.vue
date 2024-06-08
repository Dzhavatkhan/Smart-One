<template>
    <div class="pcSlider w-[352px] h-[465px]">
        <swiper
        :style="{
          '--swiper-navigation-color': '#000',
          '--swiper-pagination-color': '#000',
          '--swiper-slide-active-width': '274px', 
        }" :spaceBetween="10" :thumbs="{ swiper: thumbsSwiper }" :modules="modules" class="mySwiper2 mb-8">
        <swiper-slide v-for="(item, index) in slider" :key="index" class="swipSlid">
        <div class="img-block flex justify-center items-center max-w-[274px] max-h-[335px]">
            <img :src="item" />
        </div>
        </swiper-slide>
                </swiper>
                <swiper
                :navigation="true"
                @swiper="setThumbsSwiper"
                :spaceBetween="10"
                :slidesPerView="4"
                :freeMode="true"
                :watchSlidesProgress="true"
                :modules="modules"
                class="otherImg"
                >
                <swiper-slide  v-for="(item, index) in slider" :key="index">
                    <div class="img-block min-w-[66px] cursor-pointer max-w-[82px] max-h-[99px]">
                        <img :src="item" />
                    </div>
                </swiper-slide>
            </swiper>
    </div>
</template>

<script setup>
    import { FreeMode, Navigation, Thumbs } from 'swiper/modules';
    import { onMounted, ref } from "vue";
    import { Swiper, SwiperSlide } from 'swiper/vue';


    const props = defineProps({
        product: Object,
        slider: Object
    })
    const thumbsSwiper = ref(null);
    const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
    };
    const modules = [FreeMode, Navigation, Thumbs]
</script>

<style scoped>
    .pcSlider img{
        max-width: 274px;
        max-height: 335px;
    }
    .otherImg img{
        max-width: 82px;
        max-height: 99px;
    }
</style>