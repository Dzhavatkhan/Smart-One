<template>
    <button @click="createProductModal = !createProductModal" class="w-20 h-10 rounded-md duration-300 hover:text-white hover:bg-[#081225] border border-[#081225]">
        Создать
    </button>
    <transition name="fade">
        <div v-show="createProductModal" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[900px] px-10 py-5 flex flex-col just gap-3">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="createProductModal = !createProductModal; console.log(createProductModal)" src="/public/img/admin/Multiply.svg">
                    </div>
                    <div class="modal-content h-full overflow-auto  flex flex-col gap-10 items-center">
                        <div class="title text-[32px] text=[#151528] w-full text-center">
                            Создать товар
                        </div>
                        <form class="flex flex-col w-full gap-10 items-center">
                            <div class="img-input w-full">
                                    <label for="input-file" ref="inputFile" id="drop-area" @drop.prevent="onDrop">
                                        <input @change="getAvatar" type="file" name="avatar" id="input-file" hidden>
                                        <div ref="view" class="img-view py-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center w-full h-full rounded-md border border-[#151528]">
                                            <img src="/public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                            <p class="text-center">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                            <span class="duration-100">Загружайте изображение с рабочего стола</span>
                                        </div>
                                    </label>
                            </div>
                            <input type="text" v-model="subcategory" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Название товара">
                            <input type="text" v-model="subcategory" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Цвет товара">
                            <input type="text" v-model="subcategory" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Цена товара">
                            <input type="text" v-model="subcategory" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Скидка">
                            <div class="select w-full flex flex-col gap-5">
                                <select v-model="selectedCategory" @change="changeSelect" name="" id="" class="w-full border border-[#151528]">
                                    <option v-for="category in categories" :key="category.id" :value="category">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <select v-show="subcategories.length>0"  name="" id="" class="w-full border border-[#151528]">
                                    <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">{{ subcategory.name }}</option>
                                </select>
                            </div>
                            <div class="specification flex flex-col gap-3 w-full">
                                <input type="text" v-model="subcategory" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Название характеристики">
                                <textarea class="border w-full border-[#151528]" id="" cols="30" rows="10" placeholder="Характеристика"></textarea>
                            </div>

                            <button @click.prevent="createProduct()" class="send h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">Создать</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
    import { ref, onMounted, onUnmounted } from "vue"
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'

    let createProductModal = ref(false)
    const userStore = useUserStore();
    let subcategory = ref([]);
    let categories = ref([]);
    let selectedCategory = ref([]);
    let subcategories = ref([]);
    let avatar = ref(null);
    const view = ref(null)


    async function getCategories(){
        let response = await axios.get("/api/getCategories", {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        categories.value =  response.data.categories
        console.log(categories.value);
    }
    function changeSelect(){
        console.log(selectedCategory.value.lists);
        subcategories.value = selectedCategory.value.lists

    }
    function getAvatar(e){
        avatar.value = e.target.files[0]
        const blob = new Blob([`${e.target.files[0]}`], { type: 'text/plain' });

        let background = URL.createObjectURL(e.target.files[0])
        view.value.style.backgroundRepeat = "no-repeat"
        view.value.style.width = "100%";
        view.value.style.backgroundSize = "100%";
        view.value.style.backgroundImage = `url(${background})`
        view.value.style.minHeight = "400px";
        view.value.textContent= ''
        console.log(background);
        console.log(avatar.value);
    }

    async function updateAvatar(e){
        e.preventDefault();
        let formData = new FormData();
        console.log(userStore.token);
        formData.append("avatar", avatar.value)
        console.log(avatar.value);
        let response = await axios.post(`/api/updateUserAvatar/id${userStore.id}`, formData,
        {
            headers:
                {
                    Authorization: `Bearer ${userStore.token}`,
                }
        }
)
        .then((result) => {
            console.log(result);
            userStore.setUserDetails(result)
            eventBus.emit('updateAvatar', '')
        }).catch((err) => {
            console.log(err);
        });

    }

    const emit = defineEmits(['files-dropped'])

    function onDrop(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        const blob = new Blob([`${e.dataTransfer.files[0]}`], { type: 'text/plain' });

        let background = URL.createObjectURL(e.dataTransfer.files[0])
        avatar.value = e.dataTransfer.files[0];
        view.value.style.backgroundImage = `url(${background})`
        view.value.style.height = "400px";
        view.value.textContent= ''
        console.log(avatar.value);
        console.log(background);
    }

    function preventDefaults(e) {
        e.preventDefault()
    }

    const events = ['dragenter', 'dragover', 'dragleave', 'drop']

    onMounted(async() => {
        await getCategories();

        events.forEach((eventName) => {
            document.body.addEventListener(eventName, preventDefaults)
        })
    })

    onUnmounted(() => {

        events.forEach((eventName) => {
            document.body.removeEventListener(eventName, preventDefaults)
        })
    })


    async function createProduct(id){
        createSubcategoryModal = !createSubcategoryModal
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
