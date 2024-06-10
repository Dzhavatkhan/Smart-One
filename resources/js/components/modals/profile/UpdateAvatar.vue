<template>
    <img @click="updateAvatarModal = !updateAvatarModal" src="@public/img/profile/Group 17.svg" alt="" class="edit w-[30px] relative left-16 bottom-7 cursor-pointer max-md:hidden max-sm:hidden">
    <img @click="updateAvatarModal = !updateAvatarModal" src="@public/img/profile/Group 16.svg" alt="" class=" hidden edit w-[30px] relative left-8 bottom-5 cursor-pointer max-md:block max-md:left-9 max-sm:block">

    <transition name="fade">
        <div v-if="updateAvatarModal" class="fixed inset-0 m-auto bg-black bg-opacity-60 z-10">
            <div class="w-max fixed inset-0 m-auto z-20 flex justify-center items-center">
                <div class="bg-white shadow-md w-[695px] h-[600px] px-5 py-5 flex flex-col just gap-6 max-sm:w-[400px]">
                    <div class="img flex w-full justify-end">
                        <img class="close down text-right cursor-pointer w-[20px]" @click="updateAvatarModal = !updateAvatarModal" src="@public/img/admin/Multiply.svg">
                    </div>
                    <form  class="flex flex-col h-full items-center justify-between gap-3">
                        <div v-if="saveImage.length == 0" class="hero h-full w-full">
                            <label for="input-file" class="" ref="inputFile" id="drop-area" @drop.prevent="onDrop">
                                <input @change="getAvatar" type="file" name="avatar" id="input-file" hidden>
                                <div ref="view" class="img-view py-5 cursor-pointer flex flex-col bg-white duration-200 hover:bg-[#DEFCFF] items-center justify-center w-full h-full rounded-md border border-[#151528]">
                                    <img src="@public/img/profile/Upload to the Cloud.svg" class="w-24" alt="">
                                    <p class="text-center">Перетащите файл сюда или кликните <br>чтобы загрузить изображение</p>
                                    <span class="duration-100">Загружайте изображение с рабочего стола</span>
                                </div>
                            </label>
                        </div>
                        <div v-else class="flex flex-col justify-center items-center py-5 w-full">
                            <div @click="removeImage(saveImage)" class="bg-white duration-300 hover:scale-110 shadow-md relative top-0 left-48 rounded-full h-8 w-8 flex justify-center items-center">
                                <img class="close down text-right cursor-pointer w-[20px] max-sm:max-h-[250px] z-10" src="@public/img/admin/Multiply.svg">
                            </div>
                            <img class="w-4/5" :src="saveImage" alt="">
                        </div>
                        <button class="h-[70px] w-1/2 text-white rounded-md text-[24px] duration-300 bg-[#151528] hover:text-[#151528] hover:border hover:border-[#151528] hover:bg-white" @click="updateAvatar">
                            Отправить
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </transition>
    </template>
<style scoped>
    .hero:hover span{
        color: #151528;
        font-weight: 700;
    }
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

    let userStore = useUserStore();
    const events = ['dragenter', 'dragover', 'dragleave', 'drop']
    const emit = defineEmits(['files-dropped'])    
    let updateAvatarModal = ref(false);
    let avatar = ref(null);
    let saveImage = ref([]);
    
    function getAvatar(e){
        avatar.value = e.target.files[0]
        const blob = new Blob([`${e.target.files[0]}`], { type: 'text/plain' });
        saveImage.value = URL.createObjectURL(e.target.files[0])

    }
    function removeImage(){
        avatar.value = [];
        saveImage.value = [];
    }
    async function updateAvatar(e){
        e.preventDefault();
        let formData = new FormData();
        console.log(userStore.token);
        formData.append("avatar", avatar.value)
        console.log(avatar.value);
        let response = await axios.post(`/api/updateUserAvatar/id${userStore.id}`, formData,
        {
            headers:
                {
                    Authorization: `Bearer ${userStore.token}`,
                }
        }
)
        .then((result) => {
            console.log(result);
            updateAvatarModal.value = false
            userStore.setUserDetails(result)
            eventBus.emit('updateAvatar', '')
        }).catch((err) => {
            console.log(err);
        });

    }


    function onDrop(e) {
        emit('files-dropped', [...e.dataTransfer.files])
        const blob = new Blob([`${e.dataTransfer.files[0]}`], { type: 'text/plain' });

        saveImage.value = URL.createObjectURL(e.dataTransfer.files[0])
        avatar.value = e.dataTransfer.files[0];

    }

    function preventDefaults(e) {
        e.preventDefault()
    }


    onMounted(() => {
        events.forEach((eventName) => {
            document.body.addEventListener(eventName, preventDefaults)
        })
    })

    onUnmounted(() => {
        events.forEach((eventName) => {
            document.body.removeEventListener(eventName, preventDefaults)
        })
    })
</script>

