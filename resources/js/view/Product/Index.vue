<template>
    <Header></Header>
    <div class="title max-sm:hidden w-full text-[#4E4C4C] h-[15px] pl-[200px] mt-[63px] text-[16px]">{{product.typeProduct}}/{{product.brand}}
    </div>
    <div class="title hidden max-sm:flex w-full text-[#4E4C4C] h-[15px] pl-5 mt-[15px] text-[14px]">{{product.typeProduct}}</div>
    <ProductMobileSlider class="hidden max-sm:block" :slider="slider" :product="product"></ProductMobileSlider>
    <div class="hidden mobile px-5 max-sm:block pt-5">
        <div class="product-name flex gap-1">
            <p class="font-bold">{{product.name}} </p>
            <p>{{product.description}}, {{product.color}}</p>
        </div>
        <div class="more flex flex-col mt-[34px] gap-[22px]">
            <p class="text-[#5D5D64]">артикул товара - {{product.id}}</p>
            <button class="w-full rounded-[5px] bg-[#151528] h-10 text-white">В избранное</button>
        </div>
        <div class="more flex flex-col mt-[17px] gap-[15px]">
            <p class="">{{product.description}}</p>
            <a href="#specificationContent" class="underline">Все характеристики</a>
        </div>
    </div>
    <div class="pc mt-[18px] px-[200px] flex flex-col gap-[47px] pb-20 max-sm:hidden">
        <div class="product-name flex flex-col gap-[10px]">
            <div class="name text-[#151528] text-[24px] flex gap-1">
                <p>{{product.name}}</p>
                <p>{{product.description}}, {{product.color}}</p>
            </div>
            <div class="id text-[#5D5D64] text-[12px]">артикул товара - {{product.id}}</div>
        </div>
        <div class="productContainer flex justify-between">
                <ProductSlider :product="product" :slider="slider"></ProductSlider>
            <div class="product-info flex flex-col gap-[53px]">
                <div class="flex flex-col gap-12">
                    <div v-for="specification in specifications" :key="specification.id" class="specification text-[20px] gap-1 flex">
                        <p class="text-[#5D5D64]">{{specification.title}}:</p>
                        <p class="text-[#151528]">{{specification.content}}</p>
                    </div>
                </div>
                <a href="#specificationContent" class="text-[#00C9DF] cursor-pointer underline">Все характеристики</a>
                <div class="flex gap-[75px]">
                    <div v-for="color in product.colors" :key="color.id">
                        <img v-if="currentColorId ==  color.id" :src="'/img/products/' + color.image" class="color-active shadow-sm shadow-[#05DBF2] w-[85px] h-[99px] cursor-pointer">
                        <img v-else @click="selectColor(color.id)" :src="'/img/products/' + color.image" class="w-[85px] h-[99px] cursor-pointer">
                    </div>      
                </div>
            </div>
            <div class="product-btn w-[443px] flex flex-col gap-[45px]">
                <div class="product-price font-bold text-[36px] w-full flex justify-start">{{product.price}}₽</div>
                <div class="btns w-full flex flex-col gap-[19px]">
                    <button v-if="quantityInCart == 0 || quantityInCart == null" @click="addProductToCart(product.id)" class="w-full duration-300 hover:shadow-md rounded-md h-[60px] bg-[#00E6FF]">Добавить в корзину</button>
                    <div v-else class="w-full flex justify-around items-center">
                        <div @click="deleteItemFromCart(id)" class="text-[20px] cursor-pointer">-</div>
                        <div class="font-bold">{{quantityInCart}}</div>
                        <div @click="addProductToCart(id)" class="text-[20px] cursor-pointer">+</div>
                    </div>
                    <button @click="favorite(product.id)" class="w-full duration-300 hover:shadow-lg rounded-md h-[60px] bg-[#151528] text-white">Добавить в избранное</button>
                </div>
            </div>
        </div>
    </div>
    <ProductTabs class="px-[200px]" :product="product" :id="id"></ProductTabs>



    <Footer></Footer>
    <AddCart class="hidden max-sm:flex" :product="product"></AddCart>
    <MobileMenu class="hidden max-sm:flex"></MobileMenu>

</template>

<script setup>
    import { onMounted, ref } from "vue"
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import Header from './../../components/sections/home/Header.vue'
    import Footer from './../../components/sections/home/Footer.vue'
    import MobileMenu from "./../../components/structure/Index.vue"
    import AddCart from "../../components/structure/AddCart.vue";
    import ProductSlider from './../../components/sections/home/ProductSlider.vue';
    import ProductMobileSlider from "../../components/sections/home/ProductMobileSlider.vue";
    import ProductTabs from "../../components/sections/home/ProductTabs.vue";
    import { useUserStore } from '@/store/user-store';
    import Swal from "sweetalert2";
    import eventBus from '@/eventBus'


    const userStore = useUserStore();    
    let currentColorId = ref([]);
    let props = defineProps({
        id: {
            type:String,
            default: ''
        }
    });
    let id = props.id;
    let product = ref([]);
    let specifications = ref([]);
    let slider = ref([]);
    let quantityInCart = ref([]);
    let sliderImages = [];

    async function addProductToCart(id){
        isAuth(userStore)
        let response = await axios.get(`/api/addProductToCart/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
                eventBus.emit('addProductToCart', '')
        }).catch((err) => {
            Swal.fire({
                title: 'Произошла ошибка!',
                icon: 'error',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
                })                
            });
        }
    async function deleteItemFromCart(id){
        isAuth(userStore);
        let response = await axios.get(`/api/deleteItemFromCart/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
                eventBus.emit('deleteItemFromCart', '')
        }).catch((err) => {
            Swal.fire({
                title: 'Произошла ошибка!',
                icon: 'error',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
                })                
            });        

    }    
    async function getProduct(id){
        let response = await axios.get(`/api/getProduct/id${id}`);
        product.value = response.data.product;
        specifications.value = product.value.specification.slice(0,3);
        quantityInCart.value = product.value.quantityInCart
        currentColorId.value = product.value.currentColorId
        sliderImages = product.value.slider;
        console.log(product.value);

    }
    function selectColor(id){
        currentColorId.value = id
        sliderImages = [];
        eventBus.emit('selectColor', '')
    }
    async function getSlider(){
        let image = `/img/products/${product.value.image}`;
        slider.value = [];
        if (!slider.value.includes(image)) {
            slider.value.push(image)
        }
        if (sliderImages.length == 0) {
            sliderImages = product.value.slider.filter(item => item.colorId == currentColorId.value);
            console.log(sliderImages);
            sliderImages.forEach(item => {
                    let sliderImage = `/img/products/slider/${item.slider}`;
                    if (!slider.value.includes(sliderImage)) {
                        slider.value.push(sliderImage)
                }     
            });            
        }
        else{
            sliderImages = sliderImages.filter(item => item.colorId == currentColorId.value);
            console.log(sliderImages);
            sliderImages.forEach(item => {
                    let sliderImage = `/img/products/slider/${item.slider}`;
                    if (!slider.value.includes(sliderImage)) {
                        slider.value.push(sliderImage)
                }     
            });             
        }


        console.log(slider.value);
        // slider.value.push()
    }
    function isAuth(user){
        if (user.id == null) {
            location.href = "/login"
        }
    }
    async function favorite(id){
        isAuth(userStore);
        let response = await axios.get(`/api/addProductToFavorite/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
                eventBus.emit('addProductToFavorite', '')
                console.log(props.product);
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
                console.log(err);
                Swal.fire({
                    title: 'Произошла ошибка!',
                    icon: 'error',
                    toast: true,
                    position: "bottom-right",
                    timer: 3000,
                    showConfirmButton: false,
                    confirmButtonText: false
                })                
            });
    }

    onMounted(async() => {
        await getProduct(id);
        await getSlider();
        eventBus.on('deleteItemFromCart', async()=>{
            await getProduct(id);   
        })
        eventBus.on('addProductToCart', async()=>{
            await getProduct(id);   
        })
        eventBus.on('selectColor', async()=>{
            await getSlider();
        })
    });
</script>

<style scoped>
    .color-active{
        border: 1px solid #05DBF2;
    }
</style>
