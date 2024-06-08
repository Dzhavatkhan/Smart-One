<template>

    <button @click="createCategoryModal = !createCategoryModal" class="w-20 h-10 rounded-md duration-300 hover:text-white hover:bg-[#081225] border border-[#081225]">
        Создать
    </button>
    <transition name="fade">
        <div v-show="createCategoryModal" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[700px] max-h-full px-10 py-5 flex flex-col gap-3">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="createCategoryModal = !createCategoryModal" src="@public/img/admin/Multiply.svg">
                    </div>
                    <div class="modal-content h-64 flex flex-col gap-10  justify-center items-center">
                        <div class="title text-[32px] text=[#151528] w-1/2 text-center">
                            Создать категорию
                        </div>
                        <form class="flex flex-col h-full w-full gap-20 items-center">
                            <div v-if="selectImage.length == 0" class="img-input py-5 w-full">
                                <label for="input-cat" ref="inputFile" id="drop-area" @drop.prevent="onDrop">
                                    <input @change="getImage" type="file" name="image" id="input-cat" hidden>
                                    <div ref="view" class="img-view py-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center w-full h-full rounded-md border border-[#151528]">
                                        <img src="@public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                        <p class="text-center">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                        <span class="duration-100">Загружайте изображение с рабочего стола</span>
                                    </div>
                                </label>
                            </div>
                            <div v-else class="img-input flex justify-center items-center py-5 w-full">
                                <div @click="removeImage(selectImage)" class="bg-white duration-300 hover:scale-110 shadow-md relative top-0 left-24 rounded-full h-8 w-8 flex justify-center items-center">
                                    <img class="close down text-right cursor-pointer w-[20px] max-sm:max-h-[250px]" src="@public/img/admin/Multiply.svg">
                                </div>
                                <img :src="selectImage" alt="">
                            </div>
                            <input type="text" v-model="category" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Название категории">
                            <button @click="createCategory" class="send h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">Создать</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </transition>

</template>

<script setup>
    import { ref, onMounted, onUnmounted } from 'vue';
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'

    const userStore = useUserStore();
    let createCategoryModal = ref(false)
    let blocks = ref([])
    let category = ref(null)
    let token = null;
    let image = ref([]);
    let selectImage = ref([]);
    const emit = defineEmits(['files-dropped'])
    const events = ['dragenter', 'dragover', 'dragleave', 'drop']
    let view = ref([]);


    async function createCategory(e){
        e.preventDefault();
        let formData = new FormData();
        console.log(userStore.token);
        formData.append("name", category.value);
        formData.append("image", image.value)
        let response = await axios.post("/api/createTypeProduct", formData, {
                headers: {

                    Authorization: `Bearer ${userStore.token}`,
                }
            }
        )
        eventBus.emit('createCategory', '')
        console.log(response.data);
    }
    function getImage(e){
        image.value = e.target.files[0]
        selectImage.value = URL.createObjectURL(e.target.files[0])
    }
    function removeImage(){
        selectImage.value = [];
        image.value = [];
    }
    function onDrop(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        selectImage.value = URL.createObjectURL(e.dataTransfer.files[0])
        image.value = e.dataTransfer.files[0];
    }
    function preventDefaults(e) {
        e.preventDefault()
    }

    onMounted(async() => {

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
