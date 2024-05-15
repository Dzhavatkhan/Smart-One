<template>
    <button @click="show = !show" class="h-[70px] w-full text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">
        Добавить цвет
    </button>
    <transition name="fade">
        <div v-show="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[900px] py-5 flex flex-col just gap-5 px-24">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="show = !show;" src="/public/img/admin/Multiply.svg">
                    </div>
                    <form enctype="multipart/form-data" class="form h-full w-full flex flex-col items-center gap-10 p-20">
                        <div class="img-input w-full">
                            <label for="input-color" id="drop-area" @drop.prevent="onDropColor">
                                <input type="file" id="input-color" @change="getImage" hidden>
                                    <div ref="colorDiv" class="img-colorDiv py-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center w-full h-full rounded-md border border-[#151528]">
                                    <img src="/public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                    <p class="text-center">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                    <span class="duration-100">Загружайте изображение с рабочего стола</span>
                                    </div>
                            </label>
                        </div>
                        <input type="text" v-model="colorName" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Название цвета">
                        <button v-show="colorIMG && colorName" @click.prevent="createColor(product.id)" class="h-[70px] w-full text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">
                            Создать
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
    import { onMounted, onUnmounted, ref } from "vue";
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'



    let show = ref(false);
    let colorIMG = ref([]);
    const colorDiv = ref(null)
    const userStore = useUserStore();
    const emit = defineEmits(['files-dropped'])
    const events = ['dragenter', 'dragover', 'dragleave', 'drop']
    let colorName = ref(null);
    const props = defineProps({
        product: Object,
        // Другие props
    });

    async function createColor(id){
        let formData = new FormData();
        formData.append("productId", id);
        formData.append("color", colorName.value);
        formData.append("image", colorIMG.value);
        let response = await axios.post(`/api/createColor`,formData, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            console.log(result.data);
            eventBus.emit('createColor', '')

        }).catch((err) => {
            console.log(err.response.data);
        });
    }
    function getImage(e){
        colorIMG.value = e.target.files[0]
        let background = URL.createObjectURL(e.target.files[0])
        colorDiv.value.style.backgroundRepeat = "no-repeat"
        colorDiv.value.style.width = "100%";
        colorDiv.value.style.backgroundSize = "100%";
        colorDiv.value.style.backgroundImage = `url(${background})`
        colorDiv.value.style.minHeight = "400px";
        colorDiv.value.textContent= ''
    }
    function onDropColor(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        let background = URL.createObjectURL(e.dataTransfer.files[0])
        colorIMG.value = e.dataTransfer.files[0];
        colorDiv.value.style.backgroundRepeat = "no-repeat"
        colorDiv.value.style.width = "100%";
        colorDiv.value.style.backgroundSize = "100%";
        colorDiv.value.style.backgroundImage = `url(${background})`
        colorDiv.value.style.minHeight = "400px";
        colorDiv.value.textContent= ''
        console.log(background);
        console.log(colorIMG.value);
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

</style>
