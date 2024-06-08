<template>
    <button @click="show = !show" class="more bg-[#151528] duration-200 hover:scale-110 w-[150px] text-white shadow h-10 rounded-md text-[16px] font-[Roboto] max-sm:w-24 max-sm:text-[14px]">
        Подробнее
    </button>

    <transition name="fade">
        <div v-if="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-20">
            <div class="w-max fixed inset-0 m-auto z-50 flex justify-center items-center">
                <div class="bg-white shadow-md w-[1495px] h-[800px] px-10 max-sm:px-5 py-5 flex flex-col just gap-6 max-sm:w-screen max-sm:h-full">
                    <div class="img flex w-full justify-end">
                        <img class="close down text-right cursor-pointer w-[20px]" @click="show = !show" src="../../../../../public/img/admin/Multiply.svg">
                    </div>
                    <div class="title text-[24px] flex justify-center">Мои заказы</div>
                    <div v-if="myOrders.length > 0" class="myOrders flex flex-col gap-5 w-full h-full overflow-x-hidden overflow-y-auto">
                        <div v-for="order in myOrders" :key="order.id" class="order py-3 border-b border-t border-[#D9D9D9] max-sm:text-[13px] flex items-center justify-between">
                            <div class="id">№{{ order.id }}</div>
                            <div class="name h-max overflow-hidden"> {{ order.product }} </div>
                            <div class="price">{{ order.price }}₽</div>
                            <div class="date"> {{ order.created_at }} </div>
                        </div>
                    </div>
                    <div v-else class="myOrders w-full h-full overflow-x-hidden overflow-y-auto flex justify-center items-center text-[36px]">
                        Нет заказов
                    </div>
                </div>
            </div>
        </div>

    </transition>
</template>

<script setup>
    import {ref, onMounted} from "vue"
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'


    let show = ref(false);
    const userStore = useUserStore();
    let postIndex = ref([]);
    const props = defineProps({
        myOrders: Object
    })
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