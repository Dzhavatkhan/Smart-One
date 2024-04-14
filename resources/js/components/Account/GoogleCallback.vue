<template>
    <div>
        Welcome
    </div>
</template>

<script setup>
    try {
        let response = axios.get("/api/auth/google/callback")
        console.log(response);
    } catch (error) {
        console.log(error);
    }
</script>

<style>

</style>
