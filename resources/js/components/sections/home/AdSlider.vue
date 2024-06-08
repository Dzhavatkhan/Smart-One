<template>
    <div class="content">
        <div class="images">
            <img ref="image" class="slider-item" src="@public/img/home/header/Slider.jpg">
            <img ref="image" class="slider-item" src="@public/img/home/header/SliderTwo.jpg">
        </div>
     </div>
</template>
<script setup>
    import { onMounted, ref } from "vue";
    import { useRoute } from "vue-router";
    
    let image = ref([])
    let route = useRoute();
        onMounted(() => {
            if (route.name === "home"){
                var indexValue = 0;
                function slideShow(){
                    if (route.name === "home") {
                        setTimeout(slideShow, 5000);
                    }
                var x;
                image.value = document.querySelectorAll(".slider-item");
                const img = document.querySelectorAll(".slider-item");
                for(x = 0; x < image.value.length; x++){
                        image.value[x].style.display = "none";
                    }
                    indexValue++;
                    if(indexValue > image.value.length){indexValue = 1}
                    image.value[indexValue -1].style.display = "block";
                }                    
                    slideShow();                    
            }
    })        

</script>
<style scoped>
.content{
    height: 469px;
    width: 100%;
    overflow: hidden;
    margin-top: 84px;
    margin-bottom: 65px;
    transition: all 0.5s ease-in-out;

  }
  .content .images{
    height: 100%;
    width: 100%;
    transition: all 0.5s ease-in-out;

  }
  .images img{
    height: 100%;
    width: 100%;
    transition: all 0.5s ease-in-out;

  }

</style>




