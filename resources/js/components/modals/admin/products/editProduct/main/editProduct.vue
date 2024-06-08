<template>
    <button @click="editProductModal = !editProductModal" class="h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">
        Общие
    </button>
    <transition name="fade">
        <div v-show="editProductModal" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[900px] px-10 py-5 flex flex-col just gap-3">
                    <div class="img flex w-full justify-end">
                        <img class="close text-right cursor-pointer w-[20px]" @click="editProductModal = !editProductModal; console.log(editProductModal)" src="/public/img/admin/Multiply.svg">
                    </div>
                    <div class="modal-content h-full overflow-auto  flex flex-col gap-10 items-center">
                        <div class="title text-[32px] text=[#151528] w-full text-center">
                            Редактировать товар
                        </div>
                        <form enctype="multipart/form-data" class="flex flex-col w-full gap-10 p-2 items-center">
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
                            <input type="text" v-model="name"  class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Название товара">
                            <input type="text" v-model="color" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Цвет товара">
                            <input type="text" v-model="price" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Цена товара">
                            <input type="text" v-model="description" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Описание товара">
                            <input type="text" v-model="brand" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Бренд">
                            <input type="text" v-model="percent" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Скидка">
                            <div class="select w-full flex flex-col gap-10">
                                <select v-model="selectedCategory" @change="changeSelect" name="" id="" class="w-full h-[37px] border border-[#151528]">
                                    <option selected v-for="category in categories" :key="category.id" :value="category">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <select v-show="subcategories.length > 0" v-model="selectedSubcategory" @change="changeSelect"  name="" id="" class="w-full h-[37px] border border-[#151528]">
                                    <option selected v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory">{{ subcategory.name }}</option>
                                </select>
                            </div>

                            <div class="specification flex flex-col items-center gap-10 w-full">
                                <div class="specVal w-full flex flex-wrap gap-4">
                                    <div v-show="specification.length > 0" v-for="(item, index) in specification" :key="index" class="specItem w-52 p-3 flex gap-3 border border-[#151528] items-center justify-between">
                                        <p class="cursor-pointer" @click="getSpecification(item)">{{item.title}}</p>
                                        <img @click="deleteSpecification(item)" class="close text-right cursor-pointer w-[15px]" src="/public/img/admin/Multiply.svg">
                                    </div>
                                </div>
                                <input type="text" v-model="specificationTitle" class="border-b w-full outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Название характеристики">
                                <textarea v-model="specificationBody" class="border p-3 w-full border-[#151528]" id="" cols="30" rows="10" placeholder="Характеристика"></textarea>
                                <button v-show="specificationTitle.length > 0 && specificationBody.length > 0" @click.prevent="addSpecfication(specificationTitle, specificationBody)" class="send h-[60px] w-1/3 text-white rounded-md text-[20px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">Добавить</button>
                            </div>

                            <button @click.prevent="editProduct(props.product.id)" class="send h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">Отправить</button>
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

    let editProductModal = ref(false)
    const props = defineProps({
        product: Object,
        // Другие props
    });
    const userStore = useUserStore();
    let specification = ref([]);
    specification.value = props.product.specification
    console.log(specification.value);

    let specificationTitle = ref([]);
    let specificationBody = ref([]);

    let name = ref([]);
    name.value = props.product.name

    let color = ref([]);
    color.value = props.product.color

    let description = ref([]);
    description.value = props.product.description

    let brand = ref([]);
    brand.value = props.product.brand

    let price = ref([]);
    price.value = props.product.price

    let percent = ref([]);
    percent.value = props.product.percent

    let categories = ref([]);
    let selectedCategory = ref([]);
    let selectedSubcategory = ref([]);
    let subcategories = ref([]);
    let avatar = ref(null);
    const view = ref(null)
    const emit = defineEmits(['files-dropped'])
    const events = ['dragenter', 'dragover', 'dragleave', 'drop']
    let spc_array = [];

    function getSpecification(item){
        console.log(specificationTitle.value.length, specificationBody.value.length, item.title);
        if (specificationTitle.value != item.title) {
            console.log(1);
            specificationTitle.value = item.title;
            specificationBody.value = item.content
        }
        else{
            specificationTitle.value = ''
            specificationBody.value = ''
        }
    }
    async function editProduct(id){
        let formData = new FormData();
        if(price.value != null && price.valuelength == 0){
            formData.append("price", parseInt(price.value.replace(/\s/g, ''), 10) || '')
        }
        if(price.value != null && price.value.length == 0){
            price.value = price.value.trim();
            formData.append("image", avatar.value || '')            
        }
        if(description.value != null && description.value.length != 0){
            formData.append("description", description.value || '')
        }
        if(color.value != null && color.value.length != 0){
            formData.append("color", color.value || '')
        }
        if(name.value != null && name.value.length != 0){
            formData.append("name", name.value || '')
        }        
        if(percent.value != null && percent.value.length != 0){
            formData.append("percent", percent.value || '')
        }
        if(brand.value != null && brand.value.length != 0){
            formData.append("brand", brand.value || '')
            console.log(1008);
        }                
        for (let spec = 0; spec < specification.value.length; spec++){
            spc_array.push(specification.value[spec]);
            console.log(spc_array);
            formData.append("specification", JSON.stringify(spc_array) || '')
        }
        if (selectedCategory.value.length != 0) {
            formData.append("typeProductId", selectedCategory.value.id)            
        }
        if (selectedSubcategory.value.length != 0) {
            formData.append("categoryId", selectedSubcategory.value.id)            
        }
        console.log(name.value, selectedCategory.value, percent.value, specification.value);
        let response = await axios.post(`/api/updateProduct/id${id}`, formData, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            eventBus.emit('updateProduct', '')
        }).catch((err) => {
            console.log(err);
        });



    }
    function addSpecfication(title, body){
        if (title.length > 0 && body.length > 0) {
            specification.value.push({
                title: title,
                body: body
            })
            console.log(specification, specification.length);
            specificationTitle.value = '';
            specificationBody.value  = ''
        }
    }
    function deleteSpecification(item){
        specification.value = specification.value.filter(x=> x != item)
        console.log(specification);
    }
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
        console.log(subcategories.value.length);

    }
    function getAvatar(e){
        avatar.value = e.target.files[0]
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
    function onDrop(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        const blob = new Blob([`${e.dataTransfer.files[0]}`], { type: 'text/plain' });

        let background = URL.createObjectURL(e.dataTransfer.files[0])
        avatar.value = e.dataTransfer.files[0];
        view.value.style.backgroundRepeat = "no-repeat"
        view.value.style.width = "100%";
        view.value.style.backgroundSize = "100%";
        view.value.style.backgroundImage = `url(${background})`
        view.value.style.minHeight = "400px";
        view.value.textContent= ''
        console.log(background);
        console.log(avatar.value);
    }
    function preventDefaults(e) {
        e.preventDefault()
    }

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
