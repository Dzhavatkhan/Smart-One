<template>
    <div class="profile-content flex flex-wrap w-full gap-y-[41px] justify-between max-md:gap-[30px] max-sm:gap-[30px]">
        <div class="hidden max-sm:flex max-md:flex w-full justify-start title text-[28px] text-[#4e4c4c]" >Личный кабинет</div>
        <div class="profile-info flex flex-col gap-[18px] w-[541px] h-[298px] shadow-md border-t border-gray-200 bg-[#FBFBFB] px-[28px] py-[25px] max-md:w-full max-md:h-[283px] max-sm:w-full max-sm:h-[283px]">
            <div class="profile-title flex flex-col gap-[15px]">
                <div class="content flex items-center justify-between">
                    <div class="avatarName w-full flex gap-[18px] items-center">
                        <div class="avatar w-[90px] h-[90px] max-md:h-[58px] max-md:w-[58px] max-sm:h-[58px] max-sm:w-[58px]">
                            <img class="w-full h-full rounded-full" :src="userStore.avatar" alt="">
                            <updateAvatar></updateAvatar>
                        </div>
                        <div class="name">
                            {{ userStore.name }}
                        </div>
                    </div>
                    <UpdateInfo></UpdateInfo>

                </div>
                <div class="lane h-[1px] w-full bg-[#D9D9D9]"></div>
            </div>
            <div class="profile-body flex flex-col gap-3">
                <div class="user-info flex gap-[57px]">
                    <div class="user-info-title text-[#5D5D64] font-[Roboto]">
                        Почта
                    </div>
                    <div class="user-info-body text-[#151528] overflow-hidden font-[Roboto]">
                        {{userStore.email}}
                    </div>
                </div>
                <div v-show="userStore.city != null" class="user-info flex gap-[57px]">
                    <div class="user-info-title text-[#5D5D64] font-[Roboto]">
                        Город
                    </div>
                    <div class="user-info-body text-[#151528] font-[Roboto]">
                        {{ userStore.city }}
                    </div>
                </div>
                <div class="user-info flex gap-[57px]">
                        <button class="text-[#D94E5A]" @click="logout">Выйти</button>
                        <button @click="deleteAccount" class="deleteAccount text-[#D94E5A]">Удалить аккаунт</button>
                </div>

            </div>
        </div>
        <div class="orders flex flex-col gap-[22px] w-[612px] min-h-[186px] max-h-[298px] pb-[54px] px-7 py-[18px] shadow-md border-t border-gray-200 bg-[#FBFBFB] max-md:w-full max-sm:w-full">
            <div class="order-title flex  justify-between border-b border-[#D9D9D9] pb-[12px]">
                <div class="order-title-info flex items-center gap-[23px]">
                    <img class="w-10 h-10" src="@public/img/profile/Cart.svg" alt="">
                    <div class="order-title-name title font-[Roboto] text-center text-[16px]">История заказов</div>
                </div>
                <More :myOrders="myOrders"></More>
            </div>
            <div v-show="myOrders.length > 0" v-for="order in myOrders.slice(0,2)" :key="order.id" class="order-body flex items-center  justify-between border-b border-[#D9D9D9] pb-[22px]">
                <div class="order-body-info flex items-center gap-[23px]">
                    <div class="done flex h-10 w-10 justify-center items-center">
                        <img class="w-5 h-5" src="@public/img/profile/Done.svg" alt="">
                    </div>
                    <div class="order-body-name font-[Roboto] text-center text-[16px]">№{{ order.id }}</div>
                </div>
                <div class="text-[16px] text-center font-[Roboto] w-[150px] max-md:w-24 max-sm:w-24">
                    {{ order.price }}₽
                </div>
            </div>
            <div v-show="myOrders.length == 0" class="order-body flex items-center  justify-center border-b border-[#D9D9D9] pb-[22px]">
                <div class="w-max h-max">Заказов нет.</div>
            </div>


        </div>
        <div class="favorites flex justify-between gap-[27px] items-center px-[25px] border-t border-gray-200 bg-[#FBFBFB] shadow-md w-[541px] max-md:w-full h-[85px] max-md:h-[65px] max-sm:h-[65px]">
            <div class="fav-name flex gap-[23px]">
                <router-link class="cursor-pointer" to="/profile/favorite"><img src="@public/img/home/main/Heart.svg" class="w-10 h-10 cursor-pointer" alt=""></router-link>
                <router-link to="/profile/favorite" class="fav-name cursor-pointer title text-[24px]">Избранное</router-link>
            </div>
            <div class="fav-count bg-[#151528] text-[12px] text-white rounded-full w-5 h-5 flex justify-center items-center">
                {{ favCount }}
            </div>
        </div>
        <!-- <button @click="logout">Выйти</button>
        <button @click="deleteAccount" class="deleteAccount">Удалить аккаунт</button> -->
    </div>
</template>

<script setup>
    import Swal from 'sweetalert2';
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus';
    import UpdateAvatar from './../../modals/profile/UpdateAvatar.vue'
    import { useRouter } from 'vue-router';
    import { ref, onMounted } from 'vue';
    import UpdateInfo from '../../modals/profile/UpdateInfo.vue';
    import More from '../../modals/profile/More.vue';


    const router = useRouter();
    const userStore = useUserStore();
    let myOrders = ref([]);
    let updateAvatarModal = ref(false);
    let favCount = ref(false);


    function notUserStore(){
        if (userStore.id == null) {
            let response = axios.get("/api/getUserStore", {
                headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                }})
            .then((result) => {
                console.log(result);
                userStore.setUserDetails(result)
                eventBus.emit('notUserStore', '')
            }).catch((err) => {
                console.log(err);
            });
        }
    }
    async function deleteAccount(){
        Swal.fire({
                title: 'Вы уверены?',
                icon: 'warning',
                position: "center",
                showCancelButton: true,
                cancelButtonText: "Нет",
                confirmButtonColor: "#151528",
                cancelButtonColor: "#d33",
                confirmButtonText: "Да"
            }).then(async(result) => {
                if (result.isConfirmed) {
                    let response = await axios.delete("/api/deleteUser", {
                    headers:
                    {
                        Authorization: `Bearer ${userStore.token}`,
                    }
                })
                .then((result) => {
                    userStore.clearUser();
                    router.push("/")
                    Swal.fire({
                        title: result.data.message,
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


            })

    }
    async function getMyOrders(){
        let response = await axios.get("/api/getMyOrders", {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }            
        })
        myOrders.value = response.data.orders;

    }
    async function getFavorite(){
        let response = await axios.get("/api/getFavorite", {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        favCount.value = response.data.favorites.length;

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
    onMounted(async () => {
        getFavorite();
        notUserStore();
        await getMyOrders();
        eventBus.on('favorite', async()=>{
            await getFavorite();   
        }) 
        eventBus.on('createOrder', async()=>{
            await getMyOrders();   
        }) 
    })
</script>

<style scoped>

</style>
