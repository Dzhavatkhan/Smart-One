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
                            <option :selected="colors[0]" v-for="color in colors" :key="color.id" :value="color">{{color.color}}</option>
                        </select>
                        <div class="color_cont flex flex-wrap gap-5" v-if="sliders.length>0">
                            <div v-if="selectImage.length == 0" class="img-input py-5 w-full">
                                <label for="sslider" ref="inputFile" @drop.prevent="onDrop">
                                    <input @change="getImage" type="file" name="image" id="sslider" hidden>
                                    <div ref="view" class="img-view py-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center w-full h-full rounded-md border border-[#151528]">
                                        <img src="/public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                        <p class="text-center">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                        <span class="duration-100">Загружайте изображение с рабочего стола</span>
                                    </div>
                                </label>
                            </div>
                            <div v-else class="img-input flex justify-center items-center py-5 w-full">
                                <div @click="removeImage(selectImage)" class="bg-white duration-300 hover:scale-110 shadow-md relative top-0 left-48 rounded-full h-8 w-8 flex justify-center items-center">
                                    <img class="close down text-right cursor-pointer w-[20px] max-sm:max-h-[250px]" src="/public/img/admin/Multiply.svg">
                                </div>
                                <img class="w-24" :src="selectImage" alt="">
                            </div>
                            <div v-for="slider in sliders" :key="slider.id" class="colors w-[120px] flex flex-col items-center gap-3">
                                <img :src="'/img/products/slider/' + slider.slider" class="w-12 max-h-[135px]" alt="">
                                <button @click.prevent="deleteSlider(slider.id)" class="w-full rounded-md duration-300 cursor-pointer text-[#DE0202] hover:bg-[#FFF0F0]">
                                        Удалить
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3" v-else>
                            <p class="text-[36px]">Слайдер пуст</p>
                            <div v-if="selectImage.length == 0" class="img-input py-5 w-full">
                                <label for="Islider" ref="inputFile" @drop.prevent="onDrop">
                                    <input @change="getImage" type="file" name="image" id="Islider" hidden>
                                    <div ref="view" class="img-view py-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center w-full h-full rounded-md border border-[#151528]">
                                        <img src="/public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                        <p class="text-center">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                        <span class="duration-100">Загружайте изображение с рабочего стола</span>
                                    </div>
                                </label>
                            </div>
                            <div v-else class="img-input flex flex-col justify-center items-center py-5 w-full">
                                <div @click="removeImage(selectImage)" class="bg-white duration-300 hover:scale-110 shadow-md relative top-0 left-48 rounded-full h-8 w-8 flex justify-center items-center">
                                    <img class="close down text-right cursor-pointer w-[20px] max-sm:max-h-[250px]" src="/public/img/admin/Multiply.svg">
                                </div>
                                <img class="w-24" :src="selectImage" alt="">
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
    let selectImage = ref([]);
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
        if (selectedColor.value.length == 0) {
            selectedColor.value = colors.value[0]
            console.log(selectedColor.value);
        }
        let response = await axios.get(`/api/getSlider/id${selectedColor.value.id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        });
        sliders.value = response.data.sliders
    }
    async function createSlider(){
        let formData = new FormData();
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
    function removeImage(){
        selectImage.value = [];
        sliderImage.value = [];
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
        sliderImage.value = e.target.files[0];
        selectImage.value = URL.createObjectURL(e.target.files[0])
    }
    function onDrop(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        selectImage.value = URL.createObjectURL(e.dataTransfer.files[0])
        sliderImage.value = e.dataTransfer.files[0];

    }
    function preventDefaults(e) {
        e.preventDefault()
    }

    onMounted(async() => {
        await getColor(props.product.id);
        await getSlider(selectedColor.value.id)
        eventBus.on('createSlider', async()=>{
            await getSlider();
        })
        eventBus.on('createColor', async()=>{
            await getSlider();
            await getColor(props.product.id);
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
