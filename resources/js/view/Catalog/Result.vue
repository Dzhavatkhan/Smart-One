<template>
        <Header></Header>
        <div class="w-full h-full pt-[139px] pb-[76px] px-[200px] flex gap-[169px] max-sm:flex-col max-sm:gap-10 max-sm:px-5 max-sm:py-10 max-sm:mb-32">
            <button @click="show = !show" class="w-full h-12  hidden max-sm:block rounded-md text-white bg-[#151528]">Открыть фильтры</button>

            <div class="catalog fixed inset-0 m-auto bg-white z-30" v-show="show">
                <div class="w-screen fixed inset-0 m-auto z-20 flex justify-center items-center">
                    <div class="w-full h-full px-5 py-[14px] flex flex-col gap-5">
                        <div class="filterTIt flex justify-between w-full items-center">
                            <div class=""></div>
                            <div class="title text-[24px]">Фильтры</div>
                            <img class="close text-right cursor-pointer w-[20px]" @click="show = !show" src="/public/img/admin/Multiply.svg">
                        </div>
                        <div class="filterDiv bg-white px-2 py-5 flex flex-col w-full min-h-[548px] justify-between shadow-md border-t border-r-gray-100">
                            <div class="category-block">
                                <div class="category">{{ category }}</div>
                                <div class="subcategory bg-[#05DBF2] bg-opacity-10">{{ subcategory }}</div>
                            </div>
                            <div v-show="subcategory.length == 0" class="categories flex flex-col gap-3">
                                <div v-for="list in lists" :key="list.id" @click="selectSubcategory(list.name, $event)" class="category duration-300 cursor-pointer hover:border-[black] px-[5px] border border-[#A4A4A4]">
                                    {{ list.name }}
                                </div>
                            </div>
                            <div class="range-block flex flex-col gap-[31px] w-full h-[82px]">
                                <div class="container">
                                    <div class="slider-trackMobile"></div>
                                    <input type="range" :min="minVal" :max="maxVal" step="10" id="slider-3" @change="setRangerMobile" v-model.number="minPrice">
                                    <input type="range" :min="minVal" :max="maxVal" step="10"  id="slider-4" @change="setRangerMobile" v-model.number="maxPrice">
                                </div>
                                <div class="val flex justify-between">
                                    <input :placeholder="minVal" class="w-[100px] h-10 px-2 border" type="number" @input="setRangerMobile" v-model="minPrice">
                                    <input :placeholder="maxVal" class="w-[100px] h-10 px-2 border" type="number" @input="setRangerMobile" v-model="maxPrice">
                                </div>
                            </div>
                            <div class="brands py-5 flex flex-col gap-3">
                                <div v-for="(brand, index) in brands" :key="index" @click="selectBrand(brand, $event)" class="brand duration-300 hover:border-[black] cursor-pointer px-[5px] border border-[#A4A4A4]">{{brand}}</div>
                            </div>
                            <button @click="show = !show" class="show bg-[#151528] w-full h-10 text-white">Показать результаты</button>
                        </div>            
                    </div>                        
                </div>
            </div>
            <div class="filterDiv bg-white px-2 py-5 flex flex-col w-[237px] min-h-[348px] gap-5 shadow-md border-t border-r-gray-100 max-sm:hidden">
                <div class="category-block">
                    <div class="category">{{ category }}</div>
                    <div class="subcategory bg-[#05DBF2] bg-opacity-10">{{ subcategory }}</div>
                </div>
                <div v-show="subcategory.length == 0" class="categories flex flex-col gap-3">
                    <div v-for="list in lists" :key="list.id" @click="selectSubcategory(list.name, $event)" class="category duration-300 cursor-pointer hover:border-[black] px-[5px] border border-[#A4A4A4]">
                        {{ list.name }}
                    </div>
                </div>
                <div class="range-block flex flex-col gap-[31px] w-full h-[82px]">
                    <div class="container">
                        <div class="slider-track"></div>
                        <input type="range" :min="minVal" :max="maxVal" id="slider-1" @change="setRanger" v-model.number="minPrice">
                        <input type="range" :min="minVal" :max="maxVal"  id="slider-2" @change="setRanger" v-model.number="maxPrice">
                    </div>
                    <div class="val flex justify-between">
                        <input :placeholder="minVal" class="w-[100px] h-10 px-2 border" type="number" @input="setRanger" v-model="minPrice">
                        <input :placeholder="maxVal" class="w-[100px] h-10 px-2 border" type="number" @input="setRanger" v-model="maxPrice">
                    </div>
                </div>
                <div class="brands py-5 flex flex-col gap-3">
                    <div v-for="(brand, index) in brands" :key="index" @click="selectBrand(brand, $event)" class="brand duration-300 hover:border-[black] cursor-pointer px-[5px] border border-[#A4A4A4]">{{brand}}</div>
                </div>
            </div>
            <div class="products flex flex-wrap w-full max-md:min-h-[30vh] max-sm:min-h-[30vh] gap-[44px] max-md:gap-x-0 max-md:gap-y-3 max-md:flex-wrap max-sm:gap-x-0 max-sm:gap-y-3 max-sm:justify-between">
                <FilterProduct :products="products" :isLoading="isLoading"></FilterProduct>
            </div>
        </div>             
            
        <Footer></Footer>
        <MobileMenu class="hidden max-md:flex max-sm:flex"></MobileMenu>

</template>

<script setup>
    import Footer from "../../components/sections/home/Footer.vue";
    import Header from "../../components/sections/home/Header.vue";
    import MobileMenu from "../../components/structure/Index.vue";
    import { useRouter } from "vue-router";
    import { onMounted, ref } from "vue";
    import FilterProduct from "../../components/sections/home/FilterProduct.vue";
    import axios from "axios";

    const  router = useRouter();
    let products = ref([]);
    let isLoading = ref(true);
    let selectCategory = ref([]);
    let categories = ref([]);
    let show = ref(false);
    let lists = ref([]);
    let maxVal = ref([]);
    let minVal = ref([]);
    let brands = ref([]);
    let brandActive = ref([]);
    let minPrice = ref([]);
    let maxPrice = ref([]);  
    let props = defineProps({
        category: {
            type:String,
            default: ''
        },
        subcategory: {
            type:String,
            default: ''
        }
    });

    function fillColorMobile(min, max){
        let sliderTrack = document.querySelector(".slider-trackMobile");
        let sliderMaxValue = document.getElementById("slider-3").max;
        console.log(min, max);
        let percent1 = (min / maxVal.value) * 100;
        let percent2 = (max / maxVal.value) * 100;

        sliderTrack.style.background = `linear-gradient(to right, #dadae5 ${percent1}% , #151528 ${percent1}% , #151528 ${percent2}%, #dadae5 ${percent2}%)`;
        console.log(percent1.toFixed(0), percent2.toFixed(0));

    }
    function fillColor(min, max){
        let sliderTrack = document.querySelector(".slider-track");
        let sliderMaxValue = document.getElementById("slider-1").max;

        console.log("min ",min," max ", max);
        let percent1 = (min / maxVal.value) * 100;
        let percent2 = (max / maxVal.value) * 100;
        console.log(percent1.toFixed(0), percent2.toFixed(0));
        sliderTrack.style.background = `linear-gradient(to right, #dadae5 ${percent1}% , #151528 ${percent1}% , #151528 ${percent2}%, #dadae5 ${percent2}%)`;
    }
    const setRanger = () => {
    if (minPrice.value > maxPrice.value) {
        let tmp = maxPrice.value;
        maxPrice.value = minPrice.value
        minPrice.value = tmp
    }
    
    console.log(minPrice.value, maxPrice.value);
    fillColor(minPrice.value, maxPrice.value);
    filter();
    // sortProduct();
    }
    const setRangerMobile = () => {
    if (minPrice.value > maxPrice.value) {
        let tmp = maxPrice.value;
        maxPrice.value = minPrice.value
        minPrice.value = tmp
    }
    
    console.log(minPrice.value, maxPrice.value);
    fillColorMobile(minPrice.value, maxPrice.value);
    filter();
    // sortProduct();
    }
    async function getFilterData(category, subcategory){
        let response = 0;
        if (subcategory.length != 0) {
            console.log(subcategory.length);
            response = await axios.get(`/api/getFilterData/${category}/${subcategory}`);
        } else{
            console.log(5);
            response = await axios.get(`/api/getFilterData/${category}/null`);
        }
        products.value = response.data.products;
        isLoading.value = false;
        minVal.value = response.data.min
        maxVal.value = response.data.max
        if (minVal.value == maxVal.value) {
            minVal.value = 0;
        }
        maxPrice.value = maxVal.value;
        minPrice.value = minVal.value;
        lists.value = response.data.categories[0].lists;
        brands.value = response.data.brands
        console.log(response.data, category, subcategory);
        fillColor(minPrice.value, maxPrice.value)
    }
    async function filter(){
        let response = await axios.post("/api/filter", {
            min: minPrice.value,
            max: maxPrice.value,
            category: props.category,
            subcategory: selectCategory.value,
            brand: brandActive.value
            // brand: brand.value
        });
        products.value = response.data.products
        console.log(response.data.products);
    }
    function selectBrand(brand, e){
        if (document.querySelector(".brand-active") != null) {
            if(document.querySelector(".brand-active").textContent == brand){
                document.querySelector(".brand-active").classList.remove("brand-active");
                brandActive.value = null
                console.log(1);
        } else{
            document.querySelector(".brand-active").classList.toggle("brand-active");
            e.target.classList.toggle("brand-active");
            brandActive.value = brand
            console.log(brandActive.value)
        }
        }
        else{
            e.target.classList.toggle("brand-active");
            brandActive.value = brand
        }
        filter();

    }
    function selectSubcategory(list, e){
        if (document.querySelector(".list-active") != null) {
            if(document.querySelector(".list-active").textContent == list){
                document.querySelector(".list-active").classList.remove("list-active");
                selectCategory.value = null
                console.log(1);
        } else{
            document.querySelector(".list-active").classList.toggle("list-active");
            e.target.classList.toggle("list-active");
            selectCategory.value = list
            console.log(selectCategory.value)
        }
        }
        else{
            e.target.classList.toggle("list-active");
            selectCategory.value = list
            console.log( e.target);

        }
        filter();
    }

    onMounted(async() => {
        await getFilterData(props.category, props.subcategory);
    })
</script>

<style scoped>
    .container{
        position: relative;
        width: 100%;
        height: 100px;
        margin-top: 30px;
    }
    input[type="range"]{
        padding: 0 !important;
    }
    input[type="range"]{
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 100%;
        outline: none;
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        background-color: transparent;
        pointer-events: none;
    }
    .slider-track{
        width: 100%;
        height: 5px;
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        padding: 0;
        border-radius: 5px;
    }
    .slider-trackMobile{
        width: 100%;
        height: 5px;
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        border-radius: 5px;
    }
    input[type="range"]::-webkit-slider-runnable-track{
        -webkit-appearance: none;
        height: 5px;
    }
    input[type="range"]::-moz-range-track{
        -moz-appearance: none;
        height: 5px;
    }
    input[type="range"]::-ms-track{
        appearance: none;
        height: 5px;
    }
    input[type="range"]::-webkit-slider-thumb{
        -webkit-appearance: none;
        height: 1.7em;
        width: 1.7em;
        background-color: #151528;
        cursor: pointer;
        margin-top: -9px;
        pointer-events: auto;
        border-radius: 50%;
    }
    input[type="range"]::-moz-range-thumb{
        height: 1.7em;
        width: 1.7em;
        cursor: pointer;
        border-radius: 50%;
        background-color: #151528;
        pointer-events: auto;
    }
    input[type="range"]::-ms-thumb{
        appearance: none;
        height: 1.7em;
        width: 1.7em;
        cursor: pointer;
        border-radius: 50%;
        background-color: #151528;
        pointer-events: auto;
    }
    input[type="range"]:active::-webkit-slider-thumb{
        background-color: #ffffff;
        border: 3px solid #151528;
    }
    .valuesMobile{
        background-color: #151528;
        width: 32%;
        position: relative;
        margin: auto;
        padding: 10px 0;
        border-radius: 5px;
        text-align: center;
        font-weight: 500;
        font-size: 25px;
        color: #ffffff;
    }
    .valuesMobile:before{
        content: "";
        position: absolute;
        height: 0;
        width: 0;
        border-top: 15px solid #151528;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        margin: auto;
        bottom: -14px;
        left: 0;
        right: 0;
    }
    .values{
        background-color: #151528;
        width: 32%;
        position: relative;
        margin: auto;
        padding: 10px 0;
        border-radius: 5px;
        text-align: center;
        font-weight: 500;
        font-size: 25px;
        color: #ffffff;
    }
    .values:before{
        content: "";
        position: absolute;
        height: 0;
        width: 0;
        border-top: 15px solid #151528;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        margin: auto;
        bottom: -14px;
        left: 0;
        right: 0;
    }
    input[type= "number"]::-webkit-inner-spin-button, input[type= "number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
    }
    input[type= "number"] {
        -moz-appearance: textfield;
      }    
      .list-active{
        border: 1px solid black;
      }
      .brand-active{
        border: 1px solid black;
      }
</style>