<template>
    <img class="cursor-pointer" @click="favorite(product.id)" v-if="product.isFavorite === false || userStore.id == null" src="@public/img/home/main/Favorite.svg" alt="">
    <img class="cursor-pointer" @click="favorite(product.id)" v-else src="@public/img/home/main/FavRed.svg" alt="">
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'
    import axios from 'axios';
    import Swal from 'sweetalert2';

    const userStore = useUserStore();
    const props = defineProps({
        product: Array
    })
    let isFavorite = ref([]);

    function isAuth(user){
        if (user.id == null) {
            location.href = "/login"
        }
    }
    async function checkFav(id){
        let response = await axios.get(`/api/checkFav/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })       
        isFavorite.value = response.data.isFavorite 
    }
    async function favorite(id){
        isAuth(userStore);
        console.log(props.product.isFavorite, props.product.id);       
        let response = await axios.get(`/api/addProductToFavorite/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
                eventBus.emit('favorite', '')
                console.log(props.product.isFavorite, result.data);       
                
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
        await checkFav(props.product.id)
    })
    eventBus.on('favorite', async()=>{
            await checkFav(props.product.id);   
        })  
</script>

<style scoped>

</style>