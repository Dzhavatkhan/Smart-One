<template>
    <button @click="show = !show" class="w-[87px] h-7 rounded-md duration-300 hover:scale-110 bg-[#05DBF2] font-[Roboto] text-white max-sm:hidden">Купить</button>
    <img @click="show = !show" src="/public/img/profile/Добавить.svg" alt="" class="addCart hidden max-sm:flex cursor-pointer w-8 h-8 max-sm:w-10 max-sm:h-10">

    <transition name="fade">
        <div v-if="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-20">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[600px] px-10 max-sm:px-5 py-5 flex flex-col just gap-6 max-sm:w-[400px]">
                    <div class="img flex w-full justify-end">
                        <img class="close down text-right cursor-pointer w-[20px]" @click="show = !show" src="../../../../../public/img/admin/Multiply.svg">
                    </div>
                    <div class="title text-[24px] flex justify-center">Оформление заказа</div>
                    <form  class="flex flex-col h-full items-center justify-between gap-3 max-sm:mt-5">
                        <div class="payments w-full flex justify-around">
                            <div class="w-24 checked:border checked:border-black flex justify-center items-center">
                                <input name="payment" type="radio" id="sber" hidden>
                                <label for="sber" class="w-24 h-full flex justify-center items-center">
                                    <img src="/public/img/home/payments/image 57.jpg" alt="" class="w-full">
                                </label>
                            </div>
                            <div class="w-24 checked:border checked:border-black flex justify-center items-center" >
                                <input name="payment" type="radio" id="sbp"  hidden>
                                <label for="sbp" class="w-24 h-full flex justify-center items-center">
                                    <img src="/public/img/home/payments/sds7.jpg" alt="" class="w-full">
                                </label>
                            </div>
                        </div>
                        <input v-model="postIndex" type="text" placeholder="Введите почтовый индекс" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" required>
                        <button @click.prevent="createOrder(product)" class="h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white" @click="updateInfo">
                            Оформить
                        </button>
                    </form>
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
        product: Object
    })

    async function createOrder(id){
        console.log(id);
        let response = await axios.post("/api/createOrder", {
            postIndex: postIndex.value,
            productId: id
        },
        {
            headers:
                {
                    Authorization: `Bearer ${userStore.token}`,
                }
        }
    )
    .then((result) => {
        eventBus.emit("createOrder", "")
        show.value = !show.value
        Swal.fire({
                title: `${result.data.message}`,
                icon: 'success',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
            })
    }).catch((err) => {
        
    });
    }

</script>

<style scoped>
    input:checked + label{
        border: 2px solid #00E6FF;
    }
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.2s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }    
</style>