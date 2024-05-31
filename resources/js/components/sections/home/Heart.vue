<template>
    <img class="cursor-pointer" @click="favorite(product.id)" v-if="product.isFavorite != true" src="/public/img/home/main/Favorite.svg" alt="">
    <img class="cursor-pointer" @click="favorite(product.id)" v-else src="/public/img/home/main/FavRed.svg" alt="">
</template>

<script setup>
    import { onMounted } from 'vue';
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'
    import axios from 'axios';
    import Swal from 'sweetalert2';

    const userStore = useUserStore();
    const props = defineProps({
        product: Object
    })
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
</script>

<style scoped>

</style>