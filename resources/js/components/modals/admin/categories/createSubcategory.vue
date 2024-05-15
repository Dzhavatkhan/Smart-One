<template>
    <img class="down cursor-pointer w-[30px] h-[30px]" :src="block.icons.create" @click="createSubcategoryModal = !createSubcategoryModal; console.log(createSubcategoryModal)" alt="">
    <transition name="fade">
        <div v-show="createSubcategoryModal" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[400px] px-10 py-5 flex flex-col just gap-3">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="createSubcategoryModal = !createSubcategoryModal; console.log(createSubcategoryModal)" src="/public/img/admin/Multiply.svg">
                    </div>
                    <div class="modal-content h-64 flex flex-col gap-10  justify-center items-center">
                        <div class="title text-[32px] text=[#151528] w-full text-center">
                            Создать подкатегорию
                        </div>
                        <form class="flex flex-col w-full gap-20 items-center justify-center">
                            <input type="text" v-model="subcategory" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Название подкатегории">
                            <button @click.prevent="createSubcategory(block.id)" class="send h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">Создать</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
    import { ref } from "vue"
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'

    let createSubcategoryModal = ref(false)
    const userStore = useUserStore();
    let subcategory = ref([]);
    const props = defineProps({
        block: Object,
        // Другие props
    });


    async function createSubcategory(id){
        console.log(id);
        let response = await axios.post("/api/createCategory", {name: subcategory.value, typeProductId: id}, {
                headers: {

                    Authorization: `Bearer ${userStore.token}`,
                }
            }
        )
        eventBus.emit('createSubcategory', '')

    }
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
    .down{
        transition: 0.5s;
    }
    .down:hover{
        -webkit-filter: grayscale(0) brightness(0);
        filter: grayscale(0) brightness(0);
    }
</style>
