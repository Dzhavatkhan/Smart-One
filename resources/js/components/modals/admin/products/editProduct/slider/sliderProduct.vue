<template>
    <button @click="show = !show" class="send h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">
        Слайдер
    </button>
    <transition name="fade">
        <div v-show="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[900px] py-5 flex flex-col just gap-5 px-16">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="show = !show; console.log(show)" src="/public/img/admin/Multiply.svg">
                    </div>
                    <div class="title w-full font-bold text-[36px] text-center">
                        Слайдер товара ({{ product.name }})
                    </div>
                    <form class="content h-2/3 flex flex-col justify-between gap-10">
                        <select v-model="selectedColor" @change="getSlider" name="" class="w-full h-[37px] border border-[#151528]">
                            <option v-for="color in colors" :key="color.id" :value="color">{{color.color}}</option>
                        </select>
                        <div class="color_cont flex flex-wrap gap-5" v-if="sliders.length>0">
                            <div class="img-input w-1/3 h-[171px]">
                                <label for="input-slider" id="drop-area" @drop.prevent="onDrop">
                                    <input type="file" id="input-slider" @change="getImage" hidden>
                                        <div ref="sliderDiv" class="img-sliderDiv py-5 px-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center justify-center w-full h-full rounded-md border border-[#151528]">
                                            <img src="/public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                        </div>
                                </label>
                            </div>
                            <div v-for="slider in sliders" :key="slider.id" class="colors w-[120px] flex flex-col gap-3">
                                <img :src="'/img/products/slider/' + slider.slider" class="w-full h-[135px]" alt="">
                                <button @click.prevent="deleteSlider(slider.id)" class="w-full rounded-md duration-300 cursor-pointer text-[#DE0202] hover:bg-[#FFF0F0]">
                                        Удалить
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3" v-else>
                            <p class="text-[36px]">Слайдер пуст</p>
                            <div class="img-input w-full">
                                <label for="input-slider" id="drop-area" @drop.prevent="onDrop">
                                    <input type="file" id="input-slider" @change="getImage" hidden>
                                        <div ref="sliderDiv" class="img-sliderDiv py-5 px-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center w-full h-full rounded-md border border-[#151528]">
                                        <img src="/public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                        <p class="text-center">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                        <span class="duration-100">Загружайте изображение с рабочего стола</span>
                                        </div>
                                </label>
                            </div>
                        </div>
                        <div class="w-full flex justify-center">
                            <button @click.prevent="createSlider()" class="h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">Добавить</button>
                        </div>
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
    let sliderImage = ref([]);
    const sliderDiv = ref(null);
    const userStore = useUserStore();
    const emit = defineEmits(['files-dropped']);
    const events = ['dragenter', 'dragover', 'dragleave', 'drop']
    let sliders = ref([]);
    let colors = ref([]);
    let styleDiv = 0;
    let selectedColor = ref([])
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
        console.log(response.data.colors);
        colors.value = response.data.colors[0].get_color;
        console.log(colors.value);
    }
    async function getSlider(){
        console.log(selectedColor.value.id);
        let response = await axios.get(`/api/getSlider/id${selectedColor.value.id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        });
        sliders.value = response.data.sliders
    }
    async function createSlider(){
        let formData = new FormData();
        console.log(sliderImage.value);
        formData.append("slider", sliderImage.value || '');
        formData.append("colorId", selectedColor.value.id);
        formData.append("productId", props.product.id);

        let response = await axios.post("/api/createSlider", formData,
            {
                headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
            }
        );
        eventBus.emit('createSlider', '')
        sliderDiv.style = styleDiv.style
    }
    async function deleteSlider(id){
        let response = await axios.delete(`/api/deleteSlider/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            eventBus.emit('deleteSlider', '')
        }).catch((err) => {

        });
    }
    function getImage(e){
        sliderImage.value = e.target.files[0]
        let background = URL.createObjectURL(e.target.files[0])
        styleDiv = sliderDiv.value;
        console.log(styleDiv.style);
        sliderDiv.value.style.backgroundRepeat = "no-repeat"
        sliderDiv.value.style.width = "100%";
        sliderDiv.value.style.backgroundSize = "100%";
        sliderDiv.value.style.backgroundImage = `url(${background})`
        sliderDiv.value.style.minHeight = "171px";
        sliderDiv.value.style.maxHeight = "300px";
        sliderDiv.value.textContent= ''
    }
    function onDrop(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        let background = URL.createObjectURL(e.dataTransfer.files[0])
        sliderImage.value = e.dataTransfer.files[0];
        sliderDiv.value.style.backgroundRepeat = "no-repeat"
        sliderDiv.value.style.width = "100%";
        sliderDiv.value.style.backgroundSize = "100%";
        sliderDiv.value.style.backgroundImage = `url(${background})`
        sliderDiv.value.style.minHeight = "171px";
        sliderDiv.value.style.maxHeight = "300px";
        sliderDiv.value.textContent= ''
        console.log(background);
        console.log(sliderImage.value);
    }
    function preventDefaults(e) {
        e.preventDefault()
    }

    onMounted(async() => {
        await getColor(props.product.id);
        eventBus.on('createSlider', async()=>{
            await getSlider();
        })
        eventBus.on('deleteSlider', async()=>{
            await getSlider();
        })
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
</style>
