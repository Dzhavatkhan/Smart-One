<template>
    <img @click="show = !show" src="@public/img/profile/Edit.svg" alt="" class="edit cursor-pointer max-sm:w-5">

    <transition name="fade">
        <div v-if="show" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[600px] px-5 py-5 flex flex-col just gap-6 max-md:w-[500px] max-sm:w-[400px]">
                    <div class="img flex w-full justify-end">
                        <img class="close down text-right cursor-pointer w-[20px]" @click="show = !show" src="@public/img/admin/Multiply.svg">
                    </div>
                    <div class="title text-[24px] flex justify-center">Редактировать профиль</div>
                    <form  class="flex flex-col h-full items-center justify-between gap-3 max-sm:mt-5">
                        <input type="text"  v-model="name"  @input="inputChange" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Имя">
                        <select v-if="userStore.id != null" v-model="myCity" @change="selectCity" name="" id="" class="city cursor-pointer outline-none w-full">
                            <option v-for="(city, index) in cities" :key="index" :selected="city" >{{city}}</option>
                        </select>                        
                        <select v-else v-model="myCity" @click="toProfile" name="" id="" class="city cursor-pointer outline-none w-full">
                            <option v-for="(city, index) in cities" :key="index" :selected="city" >{{city}}</option>
                        </select>
                        <button class="h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white" @click="updateInfo">
                            Отправить
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </transition>
</template>
<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.2s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
</style>
<script setup>
    import { ref, onMounted, onUnmounted } from 'vue';
    import eventBus from '@/eventBus';
    import { useUserStore } from '@/store/user-store';
    import Swal from 'sweetalert2';

    let userStore = useUserStore();
    let name = ref([]);
    name.value = userStore.name
    let show = ref(false);
    let cities = ref([
        "Москва", "Санкт-Петербург","Екатеринбург","Казань"
    ])
    let myCity = ref([])
    if (myCity.value.length == 0) {
            myCity.value = cities.value[0];
    }

    const selectCity = () => {
        userStore.city = myCity.value
        console.log(userStore.city);
    }

    async function updateInfo(e){
        e.preventDefault();
        let formData = new FormData();
        formData.append("name", name.value)
        let response = await axios.post(`/api/updateUserInfo/id${userStore.id}`, formData,
        {
            headers:
                {
                    Authorization: `Bearer ${userStore.token}`,
                }
        }
)
        .then((result) => {
            console.log(result);
            userStore.setUserDetails(result)
            eventBus.emit('updateInfo', '')
            show.value = !show.value
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
        });

    }
</script>

