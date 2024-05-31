<template>
    <div class="productTabs flex flex-col gap-[55px] max-sm:gap-[17px] max-sm:px-5 max-sm:w-screen max-sm:mt-[55px]">
        <div class="flex w-full h-[46px] border-b-[3px] border-[#F5F7FA] gap-[110px] max-sm:text-[16px] max-sm:gap-[38px] max-sm:h-[30px] max-sm:border-b-2">
            <div class="tab cursor-pointer h-full " @click="openTab('specificationContent', $event)" id="defaultOpen">Характеристики</div>
            <div class="tab cursor-pointer max-sm:h-full" @click.prevent="openTab('reviewsContent', $event)">Отзывы</div>
            <div class="tab cursor-pointer max-sm:h-full" @click.prevent="openTab('accessoriesContent', $event)">Аксессуары</div>
        </div>
        <div id="specificationContent" class="tabcontent flex-col gap-[47px] max-sm:gap-[10px]">
            <div class="hidden max-sm:block text-[20px]">Характеристики</div>
            <div v-for="specification in product.specification" :key="specification.id" class="spc flex gap-[143px] min-w-[267px] max-sm:flex-col max-sm:gap-[10px] max-sm:text-[14px]">
                <div class="spcTitle text-[#5D5D64]">{{specification.title}}</div>
                <div class="spcBody text-[#151528]">{{specification.content}}</div>
            </div>
        </div>
        <div id="reviewsContent" class="tabcontent">
            <div class="flex gap-[167px] max-sm:flex-col max-sm:items-center max-sm:gap-10">
                <div class="statistic max-sm:w-full">
                    <div class="flex gap-[22px] max-sm:gap-[7px]">
                        <div class="flex gap-[6px] max-sm:gap-[1px]">
                            <img class="w-5 h-5" src="/public/img/home/mobile/Star.svg" alt="">
                            <div v-if="product.reviews != 0" class="rate">{{avg}}</div>
                            <div v-else class="">0</div>
                        </div>
                        <div class="reviewCount">{{reviewCount}}</div>
                    </div>
                    <div class="reviewRangeCont flex flex-col w-[199px] gap-[14px] max-sm:w-full">
                        <div class="range flex justify-between items-center">
                            <div class="number">5</div>
                            <div class="progressbar rounded-[10px] five bg-[#D9D9D9] w-[140px] h-[6px] max-sm:w-[335px]"></div>
                            <div v-if="isFractional(fivePercent)" class="percent text-center">{{fivePercent.toFixed(0)}}%</div>
                            <div v-else class="percent text-center">{{fivePercent}} %</div>
                        </div>
                        <div class="range flex justify-between items-center">
                            <div class="number">4</div>
                            <div class="progressbar rounded-[10px] four bg-[#D9D9D9] w-[140px] h-[6px] max-sm:w-[335px]"></div>
                            <div v-if="isFractional(fourPercent)" class="percent text-center">{{fourPercent.toFixed(0)}}%</div>
                            <div v-else class="percent text-center">{{fourPercent}}%</div>

                        </div>
                        <div class="range flex justify-between items-center">
                            <div class="number">3</div>
                            <div class="progressbar rounded-[10px] three bg-[#D9D9D9] w-[140px] h-[6px] max-sm:w-[335px]"></div>
                            <div v-if="isFractional(fourPercent)" class="percent text-center">{{threePercent}}%</div>
                            <div v-else class="percent text-center">{{threePercent}}%</div>

                        </div>
                        <div class="range flex justify-between items-center">
                            <div class="number">2</div>
                            <div class="progressbar rounded-[10px] two bg-[#D9D9D9] w-[140px] h-[6px] max-sm:w-[335px]"></div>
                            <div v-if="isFractional(fourPercent)" class="percent text-center">{{twoPercent}}%</div>
                            <div v-else class="percent text-center">{{twoPercent}}%</div>

                        </div>
                        <div class="range flex justify-between items-center">
                            <div class="number">1</div>
                            <div class="progressbar rounded-[10px] one bg-[#D9D9D9] w-[140px] h-[6px] max-sm:w-[335px]"></div>
                            <div v-if="isFractional(fourPercent)" class="percent text-center">{{onePercent}}%</div>
                            <div v-else class="percent text-center">{{onePercent}}%</div>

                        </div>
                    </div>
                    <WriteReview :product="product"></WriteReview>
                </div>
                <div class="reviewsContainer flex flex-col gap-3">
                    <div v-for="review in reviews" :key="review.id" class="review flex flex-col gap-8 pb-[100px] max-sm:pb-[29px] max-sm:gap-0">
                        <div class="reviewHeader flex items-center gap-[9px] max-sm:gap-[8px]">
                            <img :src="review.user.avatar" alt="" class="userAvatar rounded-full w-[50px] h-[50px] max-sm:w-[38px] max-sm:h-[38px]">
                            <div class="userName flex flex-col gap-[8px] max-sm:gap-[7px]">
                                <div class="name text-[16px] max-sm:text-[14px] max-sm:font-bold">{{ review.user.name }}</div>
                                <div class="date text-[14px] text-[#5D5D64] max-sm:text-[12px]">{{review.date}}</div>
                            </div>
                            <div class="star flex items-center h-5">
                                <img src="/public/img/home/mobile/Star.svg" class="h-full w-full" alt="">
                                <div class="rate">{{ review.rate }}</div>
                            </div>
                        </div>
                        <div v-show="review.images.length > 0" class="reviewImage flex gap-[82px] px-[38px] max-sm:pt-[13px] max-sm:py-[10px] max-sm:px-[10px] max-sm:gap-9">
                            <img v-for="image in review.images" :key="image.id" :src="'/img/products/review/' + image.image" class="w-[67px] h-[94px] max-sm:h-[60px] max-sm:max-w-[63px]" alt="">
                        </div>

                        <div class="reviewBody text-[#151528] flex flex-col gap-[35px]">
                            <div class="flex flex-col justify-between gap-[41px]">
                                <div v-show="review.advantages.length > 0" class="advantages flex flex-col gap-[10px]">
                                    <div class="advTitle text-[20px] max-sm:text-[16px] max-sm:font-bold">Достоинства</div>
                                    <div class="advBody text-[16px] max-sm:text-[14px]">{{review.advantages}}</div>
                                </div>
                                <div v-show="review.disadvantages.length > 0" class="disadvantages flex flex-col gap-[10px]">
                                    <div class="dsaTitle text-[20px] max-sm:text-[16px] max-sm:font-bold">Недостатки</div>
                                    <div class="dsaBody text-[16px] max-sm:text-[14px]">{{review.disadvantages}}</div>                                
                                </div>
                                <div v-show="review.comment.length > 0" class="comment flex flex-col gap-[10px]">
                                    <div class="commentTitle text-[20px] max-sm:text-[16px] max-sm:font-bold">Комментарий</div>
                                    <div class="commentBody text-[16px] max-sm:text-[14px]">{{review.comment}}</div> 
                                </div>                                
                            </div>
                            <div v-show="userStore.id != review.user.id" class="reaction flex gap-[111px] items-center">
                                <div class="quesstion max-sm:w-[157px]">Отзыв был полезен?</div>
                                <div class="reactBtn flex gap-[15px]">
                                    <div @click="like(review.id)" class="likeBtn gap-[11px] border-t rounded-md border-gray-100 cursor-pointer flex justify-center items-center shadow-md w-[57px] h-[25px]">
                                        <div class="yep">Да</div>
                                        <div v-show="review.likes > 0" class="likeCount flex justify-center items-center rounded-full text-[10px] text-white w-[15px] h-[15px] bg-[#151528]">{{review.likes}}</div>
                                    </div>
                                    <div @click="dislike(review.id)" class="likeBtn gap-[11px] border-t rounded-md border-gray-100 cursor-pointer flex justify-center items-center shadow-md w-[57px] h-[25px]">
                                        <div class="yep">Нет</div>
                                        <div v-show="review.dislikes > 0" class="likeCount flex justify-center items-center rounded-full text-[10px] text-white w-[15px] h-[15px] bg-[#151528]">{{review.dislikes}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="accessoriesContent" class="tabcontent">a</div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { onMounted, ref } from 'vue';
    import eventBus from '@/eventBus'
    import WriteReview from '../../modals/home/WriteReview.vue';
    import { useUserStore } from '@/store/user-store';

    const userStore = useUserStore();
    const props = defineProps({
        id: {
            type:String,
            default: '',
        },
        product: Object
        // Другие props
    });
    let reviews = ref([]);
    let reviewCount = ref([])
    let avg = ref([]);
    let percent = ref([]);
    let fivePercent = ref([]);
    let fourPercent = ref([]);
    let threePercent = ref([]);
    let twoPercent = ref([]);
    let onePercent = ref([]);

    
    function getReviewCount(reviewCountLn){
        if (reviewCountLn == 0) {
                reviewCount.value = `${reviewCountLn} отзывов`
        }
        else if(reviewCountLn == 1){
                reviewCount.value = `${reviewCountLn} отзыв`
        }
        else if(reviewCountLn <=4){
            reviewCount.value = `${reviewCountLn} отзыва`
        }
        else if(reviewCountLn => 5){
            reviewCount.value = `${reviewCountLn} отзывов`
        }
    }
    function isFractional(number) {
        return number % 1 !== 0; // Возвращает true, если число не целое
    }    
    function getPercent(){
        if (reviews.value.length == 0) {
            fivePercent.value = 0 
            fourPercent.value = 0
            threePercent.value = 0
            twoPercent.value = 0
            onePercent.value = 0

        }
        else{
            fivePercent.value = reviews.value.filter(review => review.rate == 5).length * 100/reviews.value.length
            fourPercent.value = reviews.value.filter(review => review.rate == 4).length * 100/reviews.value.length
            threePercent.value = reviews.value.filter(review => review.rate == 3).length * 100/reviews.value.length
            twoPercent.value = reviews.value.filter(review => review.rate == 2).length * 100/reviews.value.length
            onePercent.value = reviews.value.filter(review => review.rate == 1).length * 100/reviews.value.length
        }

        document.querySelector(".five").style.setProperty('--percent', fivePercent.value)
        document.querySelector(".four").style.setProperty('--percent', fourPercent.value)
        document.querySelector(".three").style.setProperty('--percent', threePercent.value)
        document.querySelector(".two").style.setProperty('--percent', twoPercent.value)
        document.querySelector(".one").style.setProperty('--percent', onePercent.value)

    }
    async function getProduct(id){
        let response = await axios.get(`/api/getProduct/id${id}`);
        reviews.value = response.data.product.reviews;
        avg.value = response.data.product.avg
        let reviewCountLn = reviews.value.length;
        getReviewCount(reviewCountLn);
        getPercent();

    }
    async function like(id){
        let response = await axios.get(`/api/likeReview/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        console.log(response.data);
        eventBus.emit('like', '')

    }
    async function dislike(id){
        let response = await axios.get(`/api/dislikeReview/id${id}`, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        console.log(response.data);
        eventBus.emit('dislike', '')
    }
    function openTab(cityName, e) {        
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "flex";
        e.target.className += " active";
    }

    onMounted(async() => {
        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
        await getProduct(props.id);   
        eventBus.on('writeReview', async()=>{
            await getProduct(props.id);   
        })
        eventBus.on('like', async()=>{
            await getProduct(props.id);   
        })
        eventBus.on('dislike', async()=>{
            await getProduct(props.id);   
        })
    })
</script>

<style scoped>
    .active{
        border-bottom: 3px solid #151528;
    }
    .tabcontent {
        display: none;
        min-height: 350px;
      }
    .five::after, .one::after, .two::after, .three::after, .four::after {
        content: '';
        display: block; /* Блочный элемент */
        height: 100%; /* Высота равна высоте блока */
        background-color: #151528 !important; /* Цвет закраски */
        border-radius: 10px;
        width: calc(var(--percent) / 100 * 100%); /* Ширина закраски в процентах от переменной */
      }      
      @media not all and (min-width: 640px) {
        .active{
            border-bottom: 2px solid #151528;
        }
      }
</style>