<template>
    <div class="fixed hidden inset-0 m-auto bg-black bg-opacity-60 z-10">
        <div class="w-max h-max fixed inset-0 m-auto z-20">
            <div class="bg-white shadow-md w-[695px] h-[967px]">
                <form>
                    <input type="file" name="avatar" id="">
                    <button @click="updateAvatar">
                        Отправить
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { useRouter } from 'vue-router';

    async function updateAvatar(){
        console.log(userStore.token);
        let response = await axios.put(`/api/updateUserAvatar/id${userStore.id}`, {
            headers:
                {
                    Authorization: `Bearer ${userStore.token}`,
                }
    })
        .then((result) => {
            console.log(result);
        }).catch((err) => {
            console.log(err);
        });

    }
</script>

