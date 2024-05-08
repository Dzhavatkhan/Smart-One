<template>
    <div>
        Hello amigo
    </div>
    <router-link to="/profile/me">
        profile
    </router-link>

<div class="range-slider">
    <input type="range" step="10" min="0" max="100" @change="setRanger" v-model.number="minPrice">
    <input type="range" step="10" min="0" max="100" @change="setRanger" v-model.number="maxPrice">
</div>
    <div class="range-values">
        <input type="number" @input="setRanger" v-model="minPrice">
        <input type="number" @input="setRanger" v-model="maxPrice">
    </div>

    <div v-for="product in products" :key="product.name" class="products">
        <p>{{ product.name }}</p>
        <p>{{ product.price }}</p>

    </div>
    <div class="select">
        <select v-model="selectCategory" @change="setSelect"  name="" id="">
            <option v-for="category in categories" :key="category.id" :value="category.name" >
                {{ category.name }}
            </option>
        </select>
    </div>

</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const  router = useRouter();
const products = ref([])

let selectCategory = ref(false);
let categories = ref([]);
let minPrice = ref([]);
let maxPrice = ref([]);
let objects = [
    {
        name: "al",
        price: 2,
        category: "PC"
    },
    {
        name: "lap",
        price: 24,
        category: "laptop"
    },
    {
        name: "pop",
        price: 100,
        category: "phone"
    },
    {
        name: "alo",
        price: 60,
        category: "PC"
    }
]
products.value = objects
console.log(products.value);
minPrice.value = 0;
maxPrice.value = 100;

const setSelect = () => {
    console.log(selectCategory.value);
    sortProduct();
}
const setRanger = () => {
    if (minPrice.value > maxPrice.value) {
        let tmp = maxPrice.value;
        maxPrice.value = minPrice.value
        minPrice.value = tmp
    }
    console.log(minPrice.value, maxPrice.value);
    sortProduct();
}
 function getCategory(){
    let array = [
        {
            id:1,
            name: "laptop"
        },
        {
            id: 2,
            name: "PC"
        },
        {
            id: 256,
            name: "phone"
        }
    ]
    categories.value = array
 }
//  function sortByCategories(){
//     let filter = objects.filter(function (item){
//         if (item.category == selectCategory.value) {
//             return item;
//         }
//     })
//     products.value = filter;
//  }
 function sortProduct(){
    let filter = objects.filter(function (item){
        if (item.price >= minPrice.value && item.price <= maxPrice.value) {
            console.log(item);
            console.log(selectCategory.value);

            if (selectCategory.value == true) {
                console.log("select ", selectCategory.value);
                if (item.category == selectCategory.value) {
                    return item;
                }
            }
            else if(selectCategory.value == false){
                console.log(selectCategory.value);
                return item;
            }

        }
    })
    console.log(filter);
    products.value = filter
}

onMounted(() => {
    getCategory();
})

</script>

<style scoped>
    .range-slider{
        width: 200px;
        position: relative;
        margin: auto 16px;
        text-align: center;
    }
    input[type=range]::-webkit-slider-thumb{
        z-index: 2;
        position: relative;
        margin-top: 7px;
    }
    .range-slider input[type=range]{
        position: absolute;
        left: 0;
        bottom: 0;
    }
</style>
