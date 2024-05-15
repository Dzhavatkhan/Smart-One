<template>
    <div class="w-full h-[285px] bg-[#2C3238] flex flex-col justify-around">
        <div class="footerInfo  px-[200px] flex justify-between items-center">
            <img src="/public/img/home/header/LogoDark.svg" alt="">
            <div class="info flex gap-[121px]">
                <div class="soc flex flex-col w-[194px] gap-3">
                    <div class="title text-white text-[20px]">
                        Наши соц. сети
                    </div>
                    <div class="lane w-full h-[1px] bg-[#5D5D64]"></div>
                    <div class="soc-info flex flex-col gap-[14px] text-white text-[16px] font-[Roboto]">
                        <div class="soc-item cursor-pointer flex gap-[5px] items-center">
                            <img src="/public/img/home/footer/telegram-icon.svg" alt="">
                            <p>Telegram</p>
                        </div>
                        <div class="soc-item cursor-pointer flex gap-[5px] items-center">
                            <img src="/public/img/home/footer/vk-icon.svg" alt="">
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
                        <div class="company-item flex">
                            Политика обработки персональных данных
                        </div>
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
</template>

<script setup>

</script>

<style>
    .title{
        font-family: "Roboto Condensed";
    }
</style>
