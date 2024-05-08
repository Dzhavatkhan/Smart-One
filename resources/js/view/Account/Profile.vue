<template>
    <div>
        <img :src="userStore.avatar" class="h-48" alt="" srcset="">
        <updateAvatar></updateAvatar>
        <router-link to="/profile/me" >Личный кабинет</router-link>
        <router-link to="/profile/favorite">Избранное</router-link>
        <router-link to="/profile/cart">Корзина</router-link>
        <button @click="logout">Выйти</button>
        <button @click="deleteAccount" class="deleteAccount">Удалить аккаунт</button>
    </div>
    <div id="ProfileView">
        <router-view></router-view>
    </div>
</template>

<script setup>
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus';
    import UpdateAvatar from '../../components/modals/profile/UpdateAvatar.vue'
    import { useRouter } from 'vue-router';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';

    const userStore = useUserStore();
    const router = useRouter();
    let updateAvatarModal = ref(false);
    let avatar = `../../../../public/img/avatars/${userStore.avatar}`

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
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Да"
            }).then(async(result) => {
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
            })

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


    notUserStore();
</script>

<style scoped>
.router-link-active {
    background-color: white;
    border-top: 2px solid white;
    color: #535353;
}
</style>
