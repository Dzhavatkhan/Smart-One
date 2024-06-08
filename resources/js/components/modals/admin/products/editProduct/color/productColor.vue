<template>
    <button @click="show = !show" class="send h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">
        Цвет товара
    </button>
    <transition name="fade">
        <div v-show="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[900px] py-5 flex flex-col just gap-5 px-16">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="show = !show; console.log(show)" src="@public/img/admin/Multiply.svg">
                    </div>
                    <div class="title w-full font-bold text-[36px] text-center">
                        Цвет товара ({{ product.name }})
                    </div>
                    <div class="content h-2/3 flex flex-col justify-center gap-10">
                        <div class="color_cont flex flex-wrap gap-5">
                            <div v-for="color in colors" :key="color.id" class="colors w-[120px] flex flex-col gap-3">
                                <img :src="'/img/products/' + color.image" class="w-full h-[135px]" alt="">
                                <div class="name w-full text-center">
                                    {{color.color}}
                                </div>
                                <button @click="deleteColor(color.id)" class="w-full rounded-md duration-300 cursor-pointer text-[#DE0202] hover:bg-[#FFF0F0]">
                                        Удалить
                                </button>
                            </div>
                        </div>
                        <createColor :product="product"></createColor>
                    </div>


                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
    import { onMounted, ref } from "vue";
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'
    import createColor from './createColor.vue'

    let show = ref(false);
    const userStore = useUserStore();
    let colors = ref([]);
    const props = defineProps({
        product: Object,
        // Другие props
    });

    async function getColor(id){
        let response = await axios.get(`/api/getColor/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        });
        colors.value = response.data.colors[0].get_color;

        console.log(colors.value);
    }
    async function deleteColor(id){
        let response = await axios.delete(`/api/deleteColor/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            eventBus.emit('deleteColor', '')
        }).catch((err) => {

        });
    }

    onMounted(async() => {
        await getColor(props.product.id);
        eventBus.on('createColor', async()=>{
            await getColor(props.product.id);
        })
        eventBus.on('deleteColor', async()=>{
            await getColor(props.product.id);
        })
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
