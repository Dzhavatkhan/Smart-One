<template>
    <Loading v-show="isLoading"></Loading>
    <div v-if="favorites.length > 0" class="w-full h-full max-md:gap-y-5 max-md:gap-x-5 max-sm:gap-x-0 max-sm:gap-y-5 gap-[38.07px] max-sm:justify-between flex flex-wrap">
        <div v-for="product in favorites" :key="product.id" class="product w-[275.05px] h-[351px] duration-200 hover:shadow-lg bg-white shadow-md border-t border-gray-200 flex flex-col max-sm:w-[185px] max-sm:h-[274px] max-[400px]:h-[247px] max-[400px]:w-[168px]">
            <div class="p-image w-full min-h-[186px] max-md:min-h-[155px] max-sm:min-h-[98px] flex justify-center items-center">
                <img @click="getProduct(product.id)" class="max-h-full pt-[11px] max-[400px]:w-[75px] max-[400px]:max-h-[88px] cursor-pointer max-w-[185px] max-md:pt-4 max-md:w-[96px] max-sm:pt-[16px] max-sm:w-[85px]" :src="'/img/products/' + product.image" alt="">
                <img @click="favorite(product.id)" src="@public/img/home/main/Delete.svg" class="relative cursor-pointer z-10 left-[30px] bottom-12 max-sm:left-[20px] max-sm:bottom-5 max-md:left-[70px] max-md:bottom-5" alt="">            
            </div>
            <div class="p-info justify-between pl-[19px] pr-[12px] w-full h-full flex flex-col max-sm:gap-0 max-sm:justify-between">
                <div class="p-name flex flex-col text-[20px] max-[400px]:text-[12px] pt-2 cursor-pointer max-sm:text-[14px]">
                    <div v-if="product.avg > 0" class="hidden max-md:flex max-sm:flex w-full h-[17px]">
                        <img src="@public/img/home/mobile/Star.svg" alt="">
                        <div class="revCount max-[400px]:text-[12px] text-[14px]">{{product.avg}}</div>
                    </div>
                    <div v-else class="hidden max-md:flex max-sm:flex w-full h-[17px]">
                        <img src="@public/img/home/mobile/StarEmpty.svg" alt="">
                        <div class="revCount max-[400px]:text-[12px] text-[14px]">0</div>
                    </div>
                    <div class="name max-[400px]:text-[12px] text-[20px] max-sm:text-[14px]">
                        <router-link :to="{path: '/product/id' + product.id}" class="font-semibold overflow-hidden font-[Roboto]">
                            {{product.name}}
                        </router-link>
                        {{product.description}}, {{product.color}}
                    </div>
                </div>
                <div class="p-price flex justify-between items-center pb-6 max-sm:pb-[9px]">
                    <div class="price font-semibold text-[24px] max-[400px]:text-[16px] font-[Roboto] max-sm:text-[20px]">{{product.price}}₽</div>
                    <CartBtn :product="product"></CartBtn>
                </div>
            </div>
        </div>
    
    </div>
    <div v-else class="vElse w-full h-full flex justify-center items-center">
        <div class="w-max h-max">
            Избранное пусто.
        </div>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import eventBus from '@/eventBus'
    import { useUserStore } from '@/store/user-store';
    import Swal from 'sweetalert2';
    import Loading from '../../structure/Loading.vue';
    import CartBtn from './CartBtn.vue';


    let favorites = ref([]);
    let isLoading = ref(true);
    const userStore = useUserStore();

    function getProduct(id){
        location.href = `/product/id${id}`
    }
    async function getFavorite(){
        let response = await axios.get("/api/getFavorite", {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        isLoading = false
        favorites.value = response.data.favorites;

    }
    function isAuth(user){
        if (user.id == null) {
            location.href = "/login"
        }
    }
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
    async function favorite(id){
        isAuth(userStore);
        let response = await axios.get(`/api/addProductToFavorite/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
                eventBus.emit('favorite', '')
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
        await getFavorite();
        eventBus.on('addProductToCart', async()=>{
            await getFavorite();   
        })
        eventBus.on('favorite', async()=>{
            await getFavorite();   
        })
    })
</script>

<style scoped>

</style>
