<template>
    <div class="search w-full px-10 bg-white h-20 shadow rounded-md flex justify-between items-center">
        <div class="search-box bg-[#F0F3F4] h-10 rounded-md flex justify-around px-4">
            <input type="text" placeholder="Поиск" v-model="searchQuery" @input="searchUsers" class="bg-transparent outline-none">
            <img class="w-8" src="@public/img/admin/Search.svg" alt="">
        </div>

    </div>
    <div class="panel-content overflow-auto rounded-md p-10 h-full bg-white shadow flex flex-col gap-5">
        <div class="panel-navbar flex justify-between items-center">
            <div class="text-[32px]" style="font-family: Roboto Condensened">Клиенты</div>
            <div class="text-[24px]">{{ users.length }}</div>
        </div>
        <table>
            <thead class="border-b-[3px] border-t-[3px] h-[48px]  border-[#F2F4F6]">
                <td class="flex items-center justify-center font-bold">
                    <input type="checkbox" @click="selectAll" v-model="allSelected" class="w-5 h-10 border border-[#F1F2F4]" name="" id="">
                </td>
                <td class="text-center font-bold">
                    Имя
                </td>
                <td class="text-center font-bold">
                    E-mail
                </td>
                <td class="text-center font-bold">
                    Дата
                </td>

            </thead>

            <tbody>
                <tr v-for="(user) in users" :key="user.id">
                    <td class="text-center flex justify-center items-center">
                        <input type="checkbox" v-model="checkbox" class="w-5 h-5 border border-[#F1F2F4]" name="" id="">
                    </td>
                    <td class="text-center">{{ user.name }}</td>
                    <td class="text-center">{{ user.email }}</td>
                    <td class="text-center">{{ user.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import { useUserStore } from '@/store/user-store';
    import Swal from 'sweetalert2';


    let userStore = useUserStore();
    let searchQuery = ref([])
    let allSelected = ref(false);
    let users = ref([]);
    let checkbox = [];
    let selected = [];
    let count = 0;

    async function getUsers(){
        let response = await axios.get("/api/getUsers",{
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        });
        users.value = response.data.users
    }
    async function deleteUser(){
        let error = 0;
        let message = "msg"

        for(let id in selected){
            let response = await axios.delete(`/api/deleteUser/id${selected[id]}`, {
                headers:
                    {
                        Authorization: `Bearer ${userStore.token}`,
                    }
            })
            .then((result) => {
                 message = result.data.message
            }).catch((err) => {
                error = 1;
                 message = err.response.data.message
            });
        }
        if (error == 0) {
            Swal.fire({
                            title: message,
                            icon: 'success',
                            toast: true,
                            position: "bottom-right",
                            timer: 3000,
                            showConfirmButton: false,
                            confirmButtonText: false
            })
        } else{
            Swal.fire({
                        title: message,
                        icon: 'error',
                        toast: true,
                        position: "bottom-right",
                        timer: 10000,
                        showConfirmButton: false,
                        confirmButtonText: false
                        })
        }
    }
    function searchUsers(){

        if (searchQuery.value.length > 0) {
            let response = axios.get(`/api/search/user_${searchQuery.value}`, {
                headers:
                    {
                        Authorization: `Bearer ${userStore.token}`,
                    }
            })
            .then((result) => {
                console.log(result.data.result);
                users.value = result.data.result
            }).catch((err) => {

            });
        }
        else{

        }
    }
    function selectAll(){
        selected = [];
        if (allSelected && count == 0) {
            for (let user in users.value) {
                checkbox.push(users[user]);
                selected.push(users.value[user].id);
                count = count + 1;
                console.log(selected);
            }
        }

        else{
            count = 0
            checkbox = [];
        }
    }

    onMounted( async() => {
        await getUsers();
    });
</script>

<style  scoped>

    thead td{
        padding-top: 10px !important;
        padding-right: 0;
        padding-left: 0;
        padding-bottom: 10px !important;
    }
    thead td{
        border-bottom: #F1F2F4 3px solid;
        border-top: #F1F2F4 3px solid;
    }
    table tr{
        border-top: thin solid;
        border-bottom: thin solid;
    }
    table{
        border-collapse:separate;
        border-spacing:0px 30px;
    }
    .panel-content::-webkit-scrollbar {
        width: 5px; /* Ширина всего элемента навигации */
        padding: 2px;

    }

      
    .panel-content::-webkit-scrollbar-track {
        background: #fff; /* Цвет дорожки */
    }
      
    .panel-content::-webkit-scrollbar-thumb {
        padding: 2px;
        cursor: pointer;
        transition: 0.5s;
        background-color: #050c26; /* Цвет бегунка */
        border-radius: 20px; /* Округление бегунка */
        border: 3px solid #050c26; /* Оформление границ бегунка */
    }    
    .panel-content::-webkit-scrollbar-thumb:hover {
        transform: scale(1.1)
    }
</style>
