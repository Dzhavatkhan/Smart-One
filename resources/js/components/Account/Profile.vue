<template>
    <div>
        <img :src="userStore.avatar" alt="" srcset="">
        <button @click="modalUpdateAvatar" >Обновить</button>
        <updateAvatar v-bind:open="updateAvatarModal" v-bind:close="!updateAvatarModal"></updateAvatar>
        <button @click="logout">Выйти</button>
        <button @click="deleteAccount" class="deleteAccount">Удалить аккаунт</button>
    </div>
</template>

<script setup>
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus';
    import UpdateAvatar from '../modals/profile/UpdateAvatar.vue'
    import { useRouter } from 'vue-router';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';

    const userStore = useUserStore();
    const router = useRouter();
    console.log(userStore.token);
    let updateAvatarModal = ref(false);

    console.log(userStore, userStore.name, userStore.avatar, userStore.email);
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
    function notAvatar(){
        if (userStore.avatar == null) {
            console.log(userStore.avatar == null);
            userStore.avatar = "http://127.0.0.1:8000/img/avatars/default.png"
        }
    }
    function modalUpdateAvatar(){
        switch (updateAvatarModal.value) {
            case false:
                updateAvatarModal.value = true
                break;
            case true:
                updateAvatarModal.value = false
                break;


        }
        console.log(updateAvatarModal.value);
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


    notAvatar();
    notUserStore();
</script>

