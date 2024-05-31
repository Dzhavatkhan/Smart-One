<template>
    <div class="w-screen px-5 h-[60px] justify-center items-center bg-white shadow-menu fixed bottom-[69px] z-10">
        <div @click.prevent="addProductToCart(product.id)" class="addCartBtn bg-[#151528] w-[390px] px-[10px] h-[41px] rounded-md flex items-center justify-between">
            <div class="flex gap-3 items-center">
                <img src="/public/img/home/header/Shopping Cart.svg" alt="">
                <div class="text-white">В корзину</div>
            </div>
            <div class="price text-white">{{product.price}}₽</div>
        </div>
    </div>
</template>

<script setup>
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'
    import Swal from 'sweetalert2';

    const userStore = useUserStore();
    const props = defineProps({
        product: Object
    })

    async function addProductToCart(id){
        if (userStore.id != null) {
            let response = await axios.get(`/api/addProductToCart/id${id}`, {
                headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
            })
            .then((result) => {
                eventBus.emit('addProductToCart', '')
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
        else{
            location.href = "/login"
        }
    }
</script>

<style scoped>
    div{
        font-family: "Roboto";
        font-size: 16px;
    }
    img{
        -webkit-filter: grayscale(100) brightness(200);
        filter: grayscale(100) brightness(200);
        width: 20px;
        height: 20px;
    }

</style>
