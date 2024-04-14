<template>
    <div class="reg-container bg-[#F2F1F1] z-0 flex justify-center max-sm:items-center items-center w-full h-screen">
        <div class="reg-wrapper flex w-[1293px] h-[790px] max-sm:flex max-sm:w-screen max-sm:h-screen max-sm:items-center max-sm:justify-between bg-white z-0">
            <div class="image-block max-sm:hidden w-[591px] h-[790px]" style="z-index:20;">
                <img src="../../../../public/img/auth-components/reg/image 13.jpg" class="w-full h-full shadow-md" alt="" srcset="">
            </div>
            <div style="z-index:50" class=" rounded-s-[70px] content-block absolute left-[42%] max-sm:left-0 max-sm:w-full max-sm:rounded-none max-sm:shadow-none max-sm:px-[30px] bg-white w-[828px] h-[790px] flex flex-col shadow-md items-center justify-center gap-[49px]">

                <div class="title w-[462px] flex justify-start max-sm:justify-center">
                    <h2 class="text-[36px] max-sm:text-[24px]" style="font-family:'Roboto Condensed'">Регистрация</h2>
                </div>

                <div class="api-elements flex justify-between w-[462px] max-sm:flex-col max-sm:items-center max-sm:w-full">
                    <div class="api-element max-sm:h-[60px] duration-100 hover:scale-110 rounded-md cursor-pointer px-2 gap-6 max-sm:gap-0 w-[210px] max-sm:w-full h-9 shadow-md flex items-center">
                        <img src="../../../../public/img/auth-components/reg/Google.svg" alt="" class="google">
                        <div class="api-element-name text-[16px] max-sm:hidden">Google</div>
                        <div class="div hidden max-sm:flex items-center justify-center w-full h-full"><p>Google</p></div>
                    </div>
                    <div class="api-element max-sm:h-[60px] duration-100 hover:scale-110 rounded-md cursor-pointer px-2 gap-6  w-[210px] max-sm:w-full h-9 shadow-md flex items-center max-sm:gap-0">
                        <img src="../../../../public/img/auth-components/reg/vk.svg" class="vk" alt=""><img src="" alt="">
                        <div class="api-element-name text-[16px] max-sm:hidden">Вконтакте</div>
                        <div class="div hidden max-sm:flex items-center justify-center w-full h-full"><p>Вконтакте</p></div>
                    </div>
                </div>

                <div class="or text-[#B2B2B2] text-[24px]">
                    -или-
                </div>
                <div class="form-block flex flex-col items-center gap-[100px] px-[30px]">
                    <form action="" class="form flex flex-col w-[462px] max-sm:w-screen gap-[36px] px-[30px]">
                        <div class="form-input w-full">
                            <input type="text"  v-model="name"  @input="inputChange" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Имя">
                        </div>
                        <div class="form-input w-full">
                            <input type="email" v-model="email"  @input="inputChange" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Эл. почта">
                        </div>
                        <div class="form-input w-full">
                            <input type="password" v-model="password" @input="inputChange" class="border-b w-full  outline-none focus:border-black text-[24px] border-[#A4A4A4] placeholder:text-[#A4A4A4] font-[Roboto]" placeholder="Пароль">
                        </div>
                    </form>
                    <div class="submit-form flex flex-col items-center gap-4 max-sm:w-full max-sm:px-[30px]">
                        <button ref="btn" @click="registration" :disabled="!openCheck" :class="!openCheck ?  ' bg-opacity-25 bg-[#05DBF2] btn w-[462px] max-sm:w-full text-[24px]  shadow-md rounded-md h-[51px]': 'btn hover:scale-105 duration-75 w-[462px] max-sm:w-full cursor-pointer text-[24px] shadow-md rounded-md bg-[#05DBF2] bg-opacity-50 h-[51px]'" >Отправить</button>
                        <a @click="login" :class="!hiddenInput ? 'text-[16px] cursor-pointer underline' : 'hidden'">У меня есть аккаунт</a>
                        <label for="check" :class="!hiddenInput ? 'hidden' : 'text-[16px] font-[Roboto] '" >
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
import {useRouter} from 'vue-router'
const router = useRouter();



const login = () => {
    router.push("/login")
}
const callback = (response) => {
  // This callback will be triggered when the user selects or login to
  // his Google account from the popup
  console.log("Handle the response", response)
  console.log(decodeCredential(response.credential));
}
let openCheck = ref(false)
let hiddenInput = ref(false);
let name = ref([]);
let email = ref([]);
let password = ref([]);

console.log(openCheck.value);
const checking = () => {
    if (openCheck.value == true) {
        openCheck.value = false
    }
    else{
        openCheck.value = true
    }
   console.log(openCheck.value);
}
const inputChange = () => {
    if( name.value.length > 0 || email.value.length > 0 || password.value.length > 0){
        hiddenInput.value = true
    }
    else{
        hiddenInput.value = false
        openCheck.value = false
    }
   console.log(hiddenInput.value);
}

async function registration (){
    let response = await axios.post("/api/registration", {
        name: name.value,
        email: email.value,
        password: password.value
    })
    .then((result) => {
        console.log(result.data.user);
    }).catch((err) => {
        console.log(err.response.data.errors);
    });
}






</script>

<style scoped>

</style>
