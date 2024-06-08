<template>
     <div class="content max-sm:block max-md:hidden mobile">
        <div class="images">
            <img ref="mobile" class="mob" src="/public/img/home/mobile/SliderMobile.jpg">
            <img ref="mobile" class="mob" src="/public/img/home/mobile/Slider (1).jpg">
        </div>
     </div>
     <div class="contentPad max-md:block max-sm:hidden mobile">
      <div class="images">
          <img ref="mobile" class="mob" src="/public/img/home/mobile/SliderMobile.jpg">
          <img ref="mobile" class="mob" src="/public/img/home/mobile/Slider (1).jpg">
      </div>
   </div>
</template>
<script setup>
    import { onMounted, ref } from "vue";
    import { useRoute } from "vue-router";

    let image = ref([])
    let mobile = ref([])
    let route = useRoute();
        onMounted(() => {
            if (route.name === "home"){
                var indexValue = 0;
                function mobileSlide(){
                    if (route.name === "home") {
                        setTimeout(mobileSlide, 5000);
                    }
                    var x;
                    mobile.value = document.querySelectorAll(".mob");
                    const mob = document.querySelectorAll(".mob");
                    for(x = 0; x < mob.length; x++){
                        mob[x].style.display = "none";
                        }
                        indexValue++;
                        if(indexValue > mob.length){indexValue = 1}
                        mob[indexValue -1].style.display = "block";
                    }
                    mobileSlide();
            }
    })

</script>
<style scoped>

@media not all and (min-width: 640px) {
    .content{
        width: 100%;
        margin: 0 !important;
        height: 210px;
        overflow: hidden;
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

}
@media not all and (min-width: 768px) {
    .contentPad{
        width: 100%;
        margin: 0 !important;
        height: 310px;
        overflow: hidden;
        transition: all 0.5s ease-in-out;
      }
      .contentPad .images{
        height: 100%;
        width: 100%;
        transition: all 0.5s ease-in-out;

      }
      .images img{
        height: 100%;
        width: 100%;
        transition: all 0.5s ease-in-out;

      }

}



</style>




