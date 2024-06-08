<template>
    <img @click="show = !show" src="/public/img/home/header/Menu.svg" alt="" class="hidden max-md:flex max-sm:flex max-md:w-5 max-sm:w-5">

    <div class="catalog fixed inset-0 m-auto bg-white z-30" v-show="show">
        <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
            <div class="w-full h-full px-5 py-[10px] flex flex-col gap-5">
                <div class="w-full flex justify-end">
                    <img class="close text-right cursor-pointer w-[20px]" @click="show = !show" src="/public/img/admin/Multiply.svg">
                </div>
                <img src="/public/img/home/header/Logo.svg" alt="">
                <div class="menu flex flex-col items-start gap-10 py-10">
                    <select v-if="userStore.id != null" v-model="myCity" @change="selectCity" name="" id="" class="city outline-none bg-transparent w-full">
                        <option v-for="(city, index) in cities" :key="index" :selected="city" >{{city}}</option>
                    </select>
                    <select v-else v-model="myCity" @click="toProfile" name="" id="">
                        <option v-for="(city, index) in cities" :key="index" :selected="city" >{{city}}</option>
                    </select>
                    <router-link to="/catalog" class="catalog">Каталог</router-link>
                    <button v-if="userStore.id == null" class="w-full h-10 text-white rounded-md duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white">Войти</button>
                    <button v-else class="text-red-400" @click="logout">Выйти</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from "vue";    
    import { useUserStore } from '@/store/user-store';
    import Swal from "sweetalert2";

    const userStore = useUserStore();
    let show = ref(false)
    let cities = ref([
        "Москва", "Санкт-Петербург","Екатринбург","Казань"
    ])
    let myCity = ref([])
    if (myCity.value.length == 0) {
            myCity.value = cities.value[0];
    }

    const selectCity = () => {
        userStore.city = myCity.value
        console.log(userStore.city);
    }

    async function logout(){
        console.log(userStore.token);
        let response = await axios.get("api/logout", {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        .then((result) => {
            userStore.clearUser();
            router.push("/");
            Swal.fire({
                title: 'Вы вышли из аккаунта',
                icon: 'success',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
            })

        }).catch((err) => {
            Swal.fire({
                title: `${err.response.data}`,
                icon: 'error',
                toast: true,
                position: "bottom-right",
                showConfirmButton: true,
                confirmButtonText: "Ок"
            })
        });
    }
</script>

<style scoped>
    .menu{
        font-family: "Roboto";
        font-size: 20px;
    }
</style>
