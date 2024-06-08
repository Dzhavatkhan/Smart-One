<template>
    <div class="reg-container bg-[#F2F1F1] z-0 flex justify-center max-md:items-center max-sm:items-center items-center w-full h-screen">
        <div class="reg-wrapper flex w-[1293px] h-[790px] max-sm:flex max-md:flex max-sm:w-screen max-md:w-screen max-sm:h-screen max-md:h-screen max-sm:items-center max-md:items-center max-sm:justify-between max-md:justify-between bg-white z-0">
            <div class="image-block max-md:hidden max-sm:hidden w-[591px] h-[790px]" style="z-index:20;">
                <img src="@public/img/auth-components/reg/image 13.jpg" class="w-full h-full shadow-md" alt="" srcset="">
            </div>
            <div style="z-index:50" class=" rounded-s-[70px] content-block absolute left-[42%] max-sm:left-0 max-md:left-0 max-sm:w-full max-md:w-full max-sm:rounded-none max-md:rounded-none max-sm:shadow-none max-md:shadow-none max-sm:px-[30px] max-md:px-[30px] bg-white w-[828px] h-[790px] flex flex-col shadow-md items-center justify-center gap-[49px]">

                <div class="title w-[462px] max-md:w-full max-sm:w-full flex justify-start max-md:justify-center max-sm:justify-center">
                    <h2 class="text-[36px] max-sm:text-[24px]" style="font-family:'Roboto Condensed'">Регистрация</h2>
                </div>

                <div class="api-elements max-md:border-t max-sm:border-t max-md:border-gray-200 max-sm:border-gray-200 flex justify-between max-md:gap-5 max-sm:gap-5 w-[462px] max-md:flex-col max-sm:flex-col max-md:w-full max-md:items-center max-sm:items-center max-sm:w-full">
                    <div @click="loginWithGoogle" class="api-element max-md:h-[60px] max-sm:h-[60px] duration-200 hover:scale-110 rounded-md cursor-pointer px-2 max-md:gap-0 gap-6 max-sm:gap-0 w-[210px] max-md:w-full max-sm:w-full h-9 shadow-md flex items-center">
                        <img src="@public/img/auth-components/reg/Google.svg" alt="" class="google w-[27px]">
                        <div  class="api-element-name text-[16px] font-[Roboto] max-md:hidden max-sm:hidden">Google</div>
                        <div  class="div max-md:text-[20px] hidden max-md:flex max-sm:flex items-center justify-center w-full h-full"><p>Google</p></div>
                    </div>
                    <div @click="loginWithYandex" class="api-element  max-md:border-t max-md:border-gray-200 max-md:h-[60px] max-sm:h-[60px] duration-200 hover:scale-110 rounded-md cursor-pointer px-2 max-md:gap-0 gap-6 max-sm:gap-0 w-[210px] max-md:w-full max-sm:w-full h-9 shadow-md flex items-center">
                        <img src="@public/img/auth-components/login/yandex-logo.svg" class="yandex w-[27px]" alt=""><img src="" alt="">
                        <div class="api-element-name text-[16px] font-[Roboto] max-md:hidden flex max-sm:hidden"><p class="text-[#FC3F1D]" >Я</p>ндекс</div>
                        <div class="div max-md:text-[20px] hidden max-sm:flex items-center max-md:flex justify-center w-full h-full">
                            <p class="ya text-[#FC3F1D]">Я</p>ндекс</div>
                    </div>
                </div>

                <div class="or text-[#B2B2B2] text-[24px]">
                    -или-
                </div>
                <div class="form-block max-md:w-full max-sm:w-full flex flex-col items-center gap-[100px] px-[30px]">
                    <form action="" class="form flex flex-col w-[462px] max-md:w-screen max-sm:w-screen gap-[36px] px-[30px]">
                        <div class="form-input w-full">
                            <input type="text"  v-model="name"  @input="inputChange" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Имя">
                            <p v-if="errors.name" class="text-[red] h-auto " >{{ errors.name[0] }}</p>
                        </div>
                        <div class="form-input w-full">
                            <input type="email" v-model="email"  @input="inputChange" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Эл. почта">
                            <p v-if="errors.email" class="text-[red] h-auto" >{{errors.email[0]}}</p>
                        </div>
                        <div class="form-input w-full">
                            <input type="password" v-model="password" @input="inputChange" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Пароль">
                            <p v-if="errors.password" class="text-[red] h-auto" >{{errors.password[0]}}</p>
                        </div>
                    </form>
                    <div class="submit-form max-md:w-full max-md:px-[30px] flex flex-col items-center gap-4 max-sm:w-full max-sm:px-[30px]">
                        <button ref="btn" @click="registration" :disabled="!openCheck" :class="!openCheck ?  ' bg-opacity-80 bg-[#151528] btn w-[462px] max-sm:w-full text-[24px] text-white  shadow-md rounded-md h-[51px]': 'btn hover:scale-105 duration-75 w-[462px] max-sm:w-full cursor-pointer text-[24px] shadow-md rounded-md bg-[#151528] text-white h-[51px]'" >Отправить</button>
                        <a @click="login" :class="!hiddenInput ? 'text-[16px] cursor-pointer underline' : 'hidden'">У меня есть аккаунт</a>
                        <label for="check" :class="!hiddenInput ? 'hidden' : 'text-[16px] font-[Roboto] max-md:text-justofy max-sm:text-justify '" >
                            <input type="checkbox" ref="check" @click="checking()" class="check w-4 " name="check" id="check">
                            Согласен на обработку персональных данных
                        </label>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
    import { onMounted, ref } from "vue";
    import { useUserStore } from '@/store/user-store';
    import eventBus from '@/eventBus';
    import Swal from 'sweetalert2'
    import {useRouter} from 'vue-router'

    const userStore = useUserStore()
    const router = useRouter();

    let openCheck = ref(false)
    let hiddenInput = ref(false);
    let name = ref([]);
    let email = ref([]);
    let password = ref([]);
    let errors = ref([]);

    const login = () => {
        router.push("/login")
    }
    const checking = () => {
        if (openCheck.value == true) {
            openCheck.value = false
        }
        else{
            openCheck.value = true
        }
    }
    const inputChange = () => {
        if( name.value.length > 0 || email.value.length > 0 || password.value.length > 0){
            hiddenInput.value = true
        }
        else{
            hiddenInput.value = false
            openCheck.value = false
        }
    }

    async function registration (){
        let response = await axios.post("/api/registration", {
            name: name.value,
            email: email.value,
            password: password.value
        })
        .then((result) => {
            userStore.setUserDetails(result)
            console.log(result.data.user.role_id)
            eventBus.emit('registration', '')
            if (result.data.role == 2) {
                console.log(result);
                router.push("/profile/me")
            } else {
                router.push("/admin/orders")
            }
            Swal.fire({
                title: 'Успешно зарегистрированы',
                icon: 'success',
                toast: true,
                position: "bottom-right",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonText: false
            })
        }).catch((err) => {
            errors.value = err.response.data.errors
        });
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
</script>

