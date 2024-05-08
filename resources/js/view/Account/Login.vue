<template>
    <div class="reg-container bg-[#F2F1F1] z-0 flex justify-center max-sm:items-center items-center w-full h-screen">
        <div class="reg-wrapper flex w-[1293px] h-[790px] max-sm:flex max-sm:w-screen max-sm:h-screen max-sm:items-center max-sm:justify-between bg-white z-0">
            <div class="image-block max-sm:hidden w-[591px] h-[790px]" style="z-index:20;">
                <img src="../../../../public/img/auth-components/login/login-image.png" class="w-full h-full shadow-md" alt="" srcset="">
            </div>
            <div style="z-index:50" class=" rounded-s-[70px] content-block absolute left-[42%] max-sm:left-0 max-sm:w-full max-sm:rounded-none max-sm:shadow-none max-sm:px-[30px] bg-white w-[828px] h-[790px] flex flex-col shadow-md items-center justify-center gap-[49px]">

                <div class="title w-[462px] max-sm:w-full flex justify-start max-sm:justify-center">
                    <h2 class="text-[36px] max-sm:text-[24px]" style="font-family:'Roboto Condensed'">Авторизация</h2>
                </div>

                <div class="api-elements max-sm:border-t max-sm:border-gray-200 flex justify-between max-sm:gap-5 w-[462px] max-sm:flex-col max-sm:items-center max-sm:w-full">
                    <div @click="loginWithGoogle" class="api-element max-sm:h-[60px] duration-200 hover:scale-110 rounded-md cursor-pointer px-2 gap-6 max-sm:gap-0 w-[210px] max-sm:w-full h-9 shadow-md flex items-center">
                        <img src="../../../../public/img/auth-components/reg/Google.svg" alt="" class="google w-[27px]">
                        <div  class="api-element-name text-[16px] font-[Roboto] max-sm:hidden">Google</div>
                        <div  class="div hidden max-sm:flex items-center justify-center w-full h-full"><p>Google</p></div>
                    </div>
                    <div @click="loginWithYandex" class="api-element max-sm:border-t max-sm:border-gray-200 max-sm:h-[60px] max-sm:items-center duration-200 hover:scale-110 rounded-md cursor-pointer px-2 gap-6  w-[210px] max-sm:w-full h-9 shadow-md flex items-center max-sm:gap-0">
                        <img src="../../../../public/img/auth-components/login/yandex-logo.svg" class="yandex w-[27px]" alt=""><img src="" alt="">
                        <div class="api-element-name text-[16px] font-[Roboto] flex max-sm:hidden"><p class="text-[#FC3F1D]" >Я</p>ндекс</div>
                        <div class="div hidden max-sm:flex items-center justify-center w-full h-full"><p>Яндекс</p></div>
                    </div>
                </div>

                <div class="or text-[#B2B2B2] text-[24px]">
                    -или-
                </div>
                <div class="form-block max-sm:w-full flex flex-col items-center gap-[100px] px-[30px]">
                    <form action="" class="form flex flex-col w-[462px] max-sm:w-screen gap-[36px] px-[30px]">
                        <div class="form-input w-full">
                            <input type="email" v-model="email"  @input="inputChange" class="border-b w-full   outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Эл. почта">
                            <p v-if="errors.message" class="text-[red] h-auto" >{{errors.message}}</p>
                            <p v-if="errors.errors && !errors.message" class="text-[red] h-auto" >{{errors.errors}}</p>
                        </div>
                        <div class="form-input w-full">
                            <input type="password" v-model="password" @input="inputChange" class="border-b w-full   outline-none hover:border-black focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Пароль">
                        </div>
                    </form>
                    <div class="submit-form flex flex-col items-center gap-4 max-sm:w-full max-sm:px-[30px]">
                        <button  ref="btn" @click="sendForm" :disabled="!hiddenInput" :class="!hiddenInput ?  ' bg-opacity-25 bg-[#05DBF2] btn w-[462px] max-sm:w-full text-[24px]  shadow-md rounded-md h-[51px]': 'btn hover:scale-105 duration-75 w-[462px] max-sm:w-full cursor-pointer text-[24px] shadow-md rounded-md bg-[#05DBF2] bg-opacity-50 h-[51px]'">Войти</button>
                        <a href="#" class="text-[16px] underline" @click="reg">У меня нет аккаунта</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
    import { onMounted, ref } from "vue";
    import Swal from 'sweetalert2'
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus'
    import {useRouter} from 'vue-router'

    let hiddenInput = ref(false);
    let email = ref([]);
    let password = ref([]);
    let errors = ref([])
    const userStore = useUserStore();
    const router = useRouter();

    const reg = () => {
        router.push("/registration")
    }

    const loginWithGoogle = async () => {
        try {
            window.location = '/api/auth/google';
        } catch (error) {
            console.error(error);
        }
    }

    const loginWithYandex = async () => {
        try {
            window.location = '/api/auth/yandex';
        } catch (error) {
            console.error(error);
        }
    }

    const inputChange = () => {
        if( email.value.length > 0 || password.value.length > 0){
            hiddenInput.value = true
        }
        else{
            hiddenInput.value = false
        }
    console.log(hiddenInput.value);
    }

    async function sendForm (){
        let response = await axios.post("/api/login", {
            email: email.value,
            password: password.value
        })
        .then((result) => {
            userStore.setUserDetails(result)
            eventBus.emit('sendForm', '')
            switch (result.data.user.role_id) {
                case 1:
                    router.push("/admin/orders")
                    break;
                case 2:
                    router.push("/profile/me")
                    break;
            }
            Swal.fire({
                title: 'Вы успешно вошли!',
                icon: 'success',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
            })
        }).catch((err) => {
            errors.value = err.response.data
        });
    }
</script>
