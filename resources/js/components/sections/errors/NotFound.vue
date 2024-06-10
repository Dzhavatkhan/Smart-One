<template>
    <div class="flex w-screen h-screen justify-center items-center">
        <div class="flex flex-col items-center gap-3">
            <div class="404 text-[64px] text-[#05DBF2]">404 | Не найдено</div>
            <div @click="$router.go(-1)" class="text-[#151528] cursor-pointer text-[48px] duration-200 hover:underline hover:underline-[#151528]">
                Вернуться обратно
            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>

</style>