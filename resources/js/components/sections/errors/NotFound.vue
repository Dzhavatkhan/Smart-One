<template>
    <div class="flex w-screen h-screen justify-center items-center">
        <div class="flex flex-col gap-3">
            <div class="404 text-[64px]">404 | Не найдено</div>
            <div @click="history.go(-1)" class="text-[#151528] text-[48px] duration-200 hover:underline hover:underline-[#151528]">
                Вернуться обратно
            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>

</style>