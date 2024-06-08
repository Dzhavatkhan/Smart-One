<template>
    <button @click="modal" class="writeReview mt-3 rounded-[5px] duration-300 border border-[#151528] text-[#151528] hover:bg-[#151528] hover:text-white w-full h-10 max-md:w-[135px] max-md:text-white max-md:bg-[#151528] max-md:text-[12px] max-sm:w-[135px] max-sm:text-white max-sm:bg-[#151528] max-sm:text-[12px]">
        Написать отзыв
    </button>

    <transition name="fade">
        <div v-show="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-50">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center max-md:items-start max-sm:items-start">
                <div class="bg-white shadow-md w-[695px] h-[900px] px-10 py-5 flex flex-col just gap-3 max-md:w-screen max-md:h-screen max-sm:w-screen max-sm:h-screen max-md:overflow-auto max-sm:overflow-auto">
                    <div class="img flex w-full justify-end">
                        <img class="close down text-right cursor-pointer w-[20px]" @click="modal" src="/public/img/admin/Multiply.svg">
                   </div>
                   <div class="revTitle text-[24px] font-bold w-full flex justify-center">
                        Оставить отзыв
                   </div>
                   <div class="stars w-full flex gap-3 justify-center items-center pt-6">
                        <div v-for="index in limit" :key="index" class="">
                            <label :for="'star' + index" class="label" @mouseenter="selectStar(index)">
                                <input class="" type="checkbox" :id="'star' + index" @click="selectStar(index)" hidden>
                                <div  @mouseout="selectStar(index)" id="starImg" src="/public/img/home/mobile/StarEmpty.svg"></div>
                            </label>
                        </div>
                   </div>
                   <textarea v-model="advantages" class="advantages p-3 w-full border border-[#151528]" cols="1" rows="10" placeholder="Что Вам понравилось?"></textarea>
                   <textarea v-model="disadvantages" class="disadventages p-3 w-full border border-[#151528]" cols="10" rows="10" placeholder="Что Вам не понравилось?" >
                   </textarea>
                   <textarea v-model="comment" class="comment p-3 w-full border border-[#151528]" cols="10" rows="10" placeholder="Ваш комментарий" >
                   </textarea>
                   <div class="images flex flex-wrap gap-4 w-full " v-show="saveImage.length>0">
                        <div v-for="image in saveImage" :key="image" class="flex">
                            <div @click="removeImage(image)" class="bg-white duration-300 hover:scale-110 shadow-md relative top-2 left-36 rounded-full h-8 w-8 flex justify-center items-center">
                                <img class="close down text-right cursor-pointer w-[20px] max-md:h-[250px] max-sm:max-h-[250px]" src="/public/img/admin/Multiply.svg">
                            </div>
                            <img class="w-[150px] h-auto" :src="image" alt="">
                        </div>
                   </div>
                   <form  class="flex flex-col w-full gap-10 p-2 items-center">
                    <div class="h-full w-full max-md:h-[150px] max-sm:h-[150px]">
                        <label for="comment" class="" id="drop-area" @drop.prevent="onDrop">
                            <input @change="getImage" type="file" name="avatar" id="comment" hidden>
                            <div ref="view" class="img-view py-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center justify-center w-full h-full rounded-md border border-[#151528]">
                                <img src="../../../../../public/img/profile/Upload to the Cloud.svg" class="w-24 " alt="">
                                <p class="text-center max-md:hidden max-sm:hidden">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                <span class="duration-100 max-md:hidden max-sm:hidden">Загружайте изображение с рабочего стола</span>
                            </div>
                        </label>
                    </div>
                    <button class="h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white" @click.prevent="writeReview(product.id)">
                        Отправить
                    </button>
                   </form>
                </div> 
            </div>  
        </div>   
    </transition>
</template>

<script setup>
    import { ref, onMounted, onUnmounted } from "vue"
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'

    const userStore = useUserStore();
    const emit = defineEmits(['files-dropped'])
    const events = ['dragenter', 'dragover', 'dragleave', 'drop']
    let show = ref(false);
    let limit = 5;
    let rate = ref([]);
    let comment = ref([]);
    let advantages = ref([]);
    let disadvantages = ref([]);
    let reviewImage = ref([]);
    let saveImage = ref([]);
    const props = defineProps({
        product: Object
    })

    function modal(){
        if (userStore.id == null) {
            location.href = "/login"
        }
        else{
            show.value = !show.value
        }
    }
    function selectStar(index, index1){
        let images = document.querySelectorAll("#starImg");
        images.forEach((star, index2) => {
            index > index2 ? star.classList.add("active") : star.classList.remove("active")
        });
        rate.value = index

    }
    function removeImage(item){
        saveImage.value = saveImage.value.filter(x=> x != item);
        reviewImage.value = reviewImage.value.filter(x=> x != item);

    }
    function getImage(e){
        reviewImage.value.push(e.target.files[0])
        const blob = new Blob([`${e.target.files[0]}`], { type: 'text/plain' });
        saveImage.value.push(URL.createObjectURL(e.target.files[0]));
    }
    function onDrop(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        const blob = new Blob([`${e.dataTransfer.files[0]}`], { type: 'text/plain' });

        saveImage.value.push(URL.createObjectURL(e.dataTransfer.files[0]))
        reviewImage.value.push(dataTransfer.files[0]);
        console.log(reviewImage.value);

    }
    async function writeReview(id){
        let formData = new FormData();
        formData.append("advantages", advantages.value);
        formData.append("disadvantages", disadvantages.value);
        formData.append("comment", comment.value);
        formData.append("rate", rate.value);
        for (let index = 0; index < reviewImage.value.length; index++) {
        //     formData.append(`reviewImage${index}`, reviewImage.value[index])
            formData.append("reviewImage[]", reviewImage.value[index]);

        }

        let response = await axios.post(`/api/writeReview/id${id}`, formData, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        eventBus.emit('writeReview', '')
        modal();
    }
    function preventDefaults(e) {
        e.preventDefault()
    }



    onMounted(() => {
        events.forEach((eventName) => {
            document.body.addEventListener(eventName, preventDefaults)
        })
    })

    onUnmounted(() => {
        events.forEach((eventName) => {
            document.body.removeEventListener(eventName, preventDefaults)
        })
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
    #starImg{
        width: 50px;
        height: 50px;
        cursor: pointer;
        transition: 0.3s;
        background-image: url("/public/img/home/mobile/StarEmpty.svg");
        background-repeat: no-repeat;
        background-size: 100%;

    }
    .active{
        background-image: url("/public/img/home/mobile/Star.svg") !important;
        background-repeat: no-repeat;
        transition: 0.3s;
        background-size: 100%;
        width: 70px;
        height: 70px;
    }

</style>