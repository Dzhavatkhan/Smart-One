<template>
    <img @click="addProductToCart(product.id)" v-if="product.quantityInCart == 0" src="/public/img/home/main/addCart.svg" alt="" class="addCart cursor-pointer w-8 h-8 max-sm:w-10 max-sm:h-10">
    <img v-else  @click="toCart()" src="/public/img/home/main/Fast Cart.svg" alt="" class="addCart cursor-pointer w-8 h-8 max-sm:w-10 max-sm:h-10">
</template>

<script setup>
    import Swal from 'sweetalert2';
    import { onMounted } from 'vue';
    import eventBus from '@/eventBus'
    import axios from 'axios';
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();
    const props = defineProps({
        product: Object
    })

    function isAuth(user){
        if (user.id == null) {
            location.href = "/login"
        }
    }
    async function toCart(){
        location.href = "/profile/cart"
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


</script>

<style scoped>

</style>