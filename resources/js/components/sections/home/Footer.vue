<template>
    <div class="w-full h-[285px] bg-[#2C3238] flex flex-col justify-around max-md:hidden max-sm:hidden">
        <div class="footerInfo  px-[200px] flex justify-between items-center">
            <img src="@public/img/home/header/LogoDark.svg" alt="">
            <div class="info flex gap-[121px]">
                <div class="soc flex flex-col w-[194px] gap-3">
                    <div class="title text-white text-[20px]">
                        Наши соц. сети
                    </div>
                    <div class="lane w-full h-[1px] bg-[#5D5D64]"></div>
                    <div class="soc-info flex flex-col gap-[14px] text-white text-[16px] font-[Roboto]">
                        <div class="soc-item cursor-pointer flex gap-[5px] items-center">
                            <img src="@public/img/home/footer/telegram-icon.svg" alt="">
                            <p>Telegram</p>
                        </div>
                        <div class="soc-item cursor-pointer flex gap-[5px] items-center">
                            <img src="@public/img/home/footer/vk-icon.svg" alt="">
                            <p>ВКонтакте</p>
                        </div>
                    </div>
                </div>
                <div class="company flex flex-col max-w-[331px] gap-3">
                    <div class="title text-white text-[20px]">
                        Компания
                    </div>
                    <div class="lane w-full h-[1px] bg-[#5D5D64]"></div>
                    <div class="company-info flex flex-col gap-[14px] text-white text-[16px] font-[Roboto]">
                        <router-link to="/rules" class="company-item flex cursor-pointer" >
                            Политика обработки персональных данных
                        </router-link>
                        <div class="company-item">
                            FAQ
                        </div>
                    </div>
                </div>
                <div class="contacts flex flex-col w-[194px] gap-3">
                    <div class="title text-white text-[20px]">
                        Контакты
                    </div>
                    <div class="lane w-full h-[1px] bg-[#5D5D64]"></div>
                    <div class="contact-info flex flex-col gap-[14px] text-white text-[16px] font-[Roboto]">
                        <div class="contact-item">
                            support@smartone.ru

                        </div>
                        <div class="contact-item">
                            +7-961-816-85-84
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footerPolitic w-full text-center justify-center items-center text-[15px] text-white font-[Roboto]">
            © 2024 Компания Smart One. Администрация Сайта не несет ответственности за размещаемые Пользователями материалы (в т.ч. информацию и изображения), их содержание и качество.
        </div>
    </div>

    <div class="mobile text-white hidden pl-[23px] pt-[25px] pr-7 pb-20 w-full h-[295px] bg-[#2C3238]  flex-col gap-[25px] max-md:flex max-sm:flex">
        <div class="text-start text-[24px] title">
            Контакты
        </div>
        <div class="info font-[Roboto] flex justify-between w-full pb-10 border-b text-[16px] border-[#F4F4F4]">
            <div class="phone">+79374823</div>
            <select  v-if="userStore.id != null" v-model="myCity" @change="selectCity" name="" id="" class="city outline-none bg-transparent w-[99px]">
                <option v-for="(city, index) in cities" :key="index" :selected="userStore.city" class="text-black" >{{city}}</option>
            </select>
            <select  v-else v-model="myCity" @click="toProfile" name="" id="" class="city outline-none bg-transparent w-[99px]">
                <option v-for="(city, index) in cities" :key="index" :selected="userStore.city" >{{city}}</option>
            </select>
        </div>
        <div class="w-full font-[Roboto] text-white text-center text-[12px] flex flex-col gap-[5px]">
            <div class="">Политика обработки персональных данных</div>
            <div>© Smart One, 2020–2024</div>
        </div>
    </div>

</template>

<script setup>
    import { ref } from 'vue';
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();
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
</script>

<style>
    .title{
        font-family: "Roboto Condensed";
    }
</style>
