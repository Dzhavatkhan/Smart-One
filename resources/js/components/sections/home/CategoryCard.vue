<template>
    <section class="flex px-[200px] flex-col gap-[42px] mb-[108px] max-md:hidden max-sm:hidden">
        <div class="title text-[#4E4C4C] text-[36px]">
            Популярные категории
        </div>
        <div class="wrapper w-full">
            <div id="left" class="fa-solid controller left fa-angle-left"></div>
            <ul class="carousel">
              <li class="card">
                <div @click="location.href='/catalog/Ноутбуки'" class="img"><img src="@public/img/home/main/image 20.jpg" alt="img" draggable="false"></div>
                <router-link class="h2" :to="{path:'/catalog/Ноутбуки'}">Ноутбуки</router-link>
              </li>
              <li class="card">
                <div @click="location.href='/catalog/Смартфоны'" class="img"><img src="@public/img/auth-components/login/login-image.png" alt="img" draggable="false"></div>
                <router-link class="h2" :to="{path:'/catalog/Смартфоны'}">Смартфоны</router-link>
              </li>
              <li class="card">
                <div @click="location.href='/catalog/Зарядки'" class="img"><img src="@public/img/home/main/Charger and usb cable type c over orange background.jpg" alt="img" draggable="false"></div>
                <router-link class="h2" :to="{path:'/catalog/Аксессуары/Зарядные устройства'}">Зарядки</router-link>
              </li>
              <li class="card">
                <div @click="location.href='/catalog/Планшеты'" class="img"><img src="@public/img/home/main/image 5.jpg" alt="img" draggable="false"></div>
                <router-link class="h2" :to="{path:'/catalog/Планшеты'}">Планшеты</router-link>
              </li>
              <li class="card">
                <div @click="location.href='/catalog/Смарт-часы'" class="img"><img src="@public/img/home/main/Smartwatch screen digital device.jpg" alt="img" draggable="false"></div>
                <router-link class="h2" :to="{path:'/catalog/Смарт-часы'}">Смарт-часы</router-link>
              </li>
              <li class="card">
                <div @click="location.href='/catalog/Наушники'" class="img"><img src="@public/img/home/main/image 8.jpg" alt="img" draggable="false"></div>
                <router-link class="h2" :to="{path:'/catalog/Наушники'}">Наушники</router-link>
              </li>
            </ul>
            <div id="right" class=" controller right"></div>
          </div>

    </section>
    <section class="hidden flex-col gap-[14px] px-5 w-full max-[400px]:px-[10px] max-[400px]:flex max-md:flex max-sm:flex">
        <div class="title text-[#4E4C4C] text-[24px]">Категории</div>
        <div class="categories h-[300px] gap-5 flex w-full justify-between flex-wrap">
            <router-link :to="{path:'/catalog/Смартфоны'}" class="category-card max-[400px]:w-[168px] max-[400px]:h-[102px] h-[112px] w-[185px] shadow-category px-[3px] pt-4 border-t border-gray-100 flex flex-col">
                <div class="category-image w-full h-[55px] max-[400px]:h-[50px] flex justify-center items-center bg-[#F4F4F4]">
                    <img src="@public/img/home/mobile/SmartPhoneMobile.png" alt="">
                </div>
                <div class="category-name max-[400px]:h-[22px] text-[14px] font-[Roboto] flex items-center justify-center h-full w-full text-center">Смартфоны</div>
            </router-link>
            <router-link :to="{path:'/catalog/Ноутбуки'}" class="category-card max-[400px]:w-[168px] max-[400px]:h-[102px] h-[112px] w-[185px] shadow-category px-[3px] pt-4 border-t border-gray-100 flex flex-col">
                <div class="category-image w-full h-[55px] max-[400px]:h-[50px] flex justify-center items-center bg-[#F4F4F4]">
                    <img src="@public/img/home/mobile/Laptop.png" alt="">
                </div>
                <div class="category-name max-[400px]:h-[22px] text-[14px] font-[Roboto] flex items-center justify-center  h-full w-full text-center">Ноутбуки</div>
            </router-link>
            <router-link :to="{path:'/catalog/Планшеты'}" class="category-card max-[400px]:w-[168px] max-[400px]:h-[102px] h-[112px] w-[185px] shadow-category px-[3px] pt-4 border-t border-gray-100 flex flex-col">
                <div class="category-image w-full h-[55px] max-[400px]:h-[50px] flex justify-center items-center bg-[#F4F4F4]">
                    <img src="@public/img/home/mobile/Pad.png" alt="">
                </div>
                <div class="category-name max-[400px]:h-[22px] text-[14px] max-h-[40px] font-[Roboto] flex items-center justify-center h-full w-full text-center">Планшеты</div>
            </router-link>
            <router-link :to="{path:'/catalog/Смарт-часы'}" class="category-card max-[400px]:w-[168px] max-[400px]:h-[102px] h-[112px] w-[185px] shadow-category px-[3px] pt-4 border-t border-gray-100 flex flex-col">
                <div class="category-image w-full h-[55px] max-[400px]:h-[50px] flex justify-center items-center bg-[#F4F4F4]">
                    <img src="@public/img/home/mobile/Smartwatch screen digital device.png" alt="">
                </div>
                <div class="category-name max-[400px]:h-[22px] text-[14px] font-[Roboto] flex items-center justify-center h-full w-full text-center">Смарт-часы</div>
              </router-link>
        </div>
    </section>
</template>

<script setup>
    import { onMounted } from "vue";

    onMounted(() => {
        const wrapper = document.querySelector(".wrapper");
        const carousel = document.querySelector(".carousel");
        const firstCardWidth = carousel.querySelector(".card").offsetWidth;
        const arrowBtns = document.querySelectorAll(".wrapper .controller");
        const carouselChildrens = [...carousel.children];
        let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;
        // Get the number of cards that can fit in the carousel at once
        let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);
        // Insert copies of the last few cards to beginning of carousel for infinite scrolling
        carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
            carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
        });
        // Insert copies of the first few cards to end of carousel for infinite scrolling
        carouselChildrens.slice(0, cardPerView).forEach(card => {
            carousel.insertAdjacentHTML("beforeend", card.outerHTML);
        });
        // Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
        // Add event listeners for the arrow buttons to scroll the carousel left and right
        arrowBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
            });
        });
        const dragStart = (e) => {
            isDragging = true;
            carousel.classList.add("dragging");
            // Records the initial cursor and scroll position of the carousel
            startX = e.pageX;
            startScrollLeft = carousel.scrollLeft;
        }
        const dragging = (e) => {
            if(!isDragging) return; // if isDragging is false return from here
            // Updates the scroll position of the carousel based on the cursor movement
            carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
        }
        const dragStop = () => {
            isDragging = false;
            carousel.classList.remove("dragging");
        }
        const infiniteScroll = () => {
            // If the carousel is at the beginning, scroll to the end
            if(carousel.scrollLeft === 0) {
                carousel.classList.add("no-transition");
                carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
                carousel.classList.remove("no-transition");
            }
            // If the carousel is at the end, scroll to the beginning
            else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
                carousel.classList.add("no-transition");
                carousel.scrollLeft = carousel.offsetWidth;
                carousel.classList.remove("no-transition");
            }
            // Clear existing timeout & start autoplay if mouse is not hovering over carousel
            clearTimeout(timeoutId);
            if(!wrapper.matches(":hover")) autoPlay();
        }
        const autoPlay = () => {
            if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
            // Autoplay the carousel after every 2500 ms
            timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
        }
        autoPlay();
        carousel.addEventListener("mousedown", dragStart);
        carousel.addEventListener("mousemove", dragging);
        document.addEventListener("mouseup", dragStop);
        carousel.addEventListener("scroll", infiniteScroll);
        wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
        wrapper.addEventListener("mouseleave", autoPlay);
    })
</script>

<style scoped>
.wrapper {
    max-width: 99vw;
    width: 100%;
    position: relative;
  }
  .wrapper .left, .wrapper .right {
    top: 50%;
    height: 50px;
    width: 50px;
    cursor: pointer;
    font-size: 1.25rem;
    position: absolute;
    text-align: center;
    line-height: 50px;
    border-radius: 50%;
    transform: translateY(-50%);
    transition: transform 0.1s linear;
    background-repeat: no-repeat;
  }
  .left{
    background: url("@public/img/home/main/left.svg");
  }
  .right{
    background: url("@public/img/home/main/right.svg");
  }
  .wrapper .controller:active{
    transform: translateY(-50%) scale(0.85);
  }
  .wrapper .controller:first-child{
    left: -22px;
  }
  .wrapper .controller:last-child{
    right: -42px;
  }
  .wrapper .carousel{
    display: grid;
    grid-auto-flow: column;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 20px;
    width: 1517px;
    border-radius: 8px;
    scroll-behavior: smooth;
    scrollbar-width: none;
  }
  .carousel::-webkit-scrollbar {
    display: none;
  }
  .carousel.no-transition {
    scroll-behavior: auto;
  }
  .carousel.dragging {
    scroll-snap-type: none;
    scroll-behavior: auto;
  }
  .carousel.dragging .card {
    cursor: grab;
    user-select: none;
  }
  .carousel :where(.card, .img) {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .carousel .card {
    scroll-snap-align: start;
    height: 278px;
    width: 237px;
    list-style: none;
    gap: 5px;
    background: #fff;
    cursor: pointer;
    flex-direction: column;
    border-radius: 8px;
  }
  .carousel .card .img {
    height: 237px;
    width: 237px;
  }
  .card .img img {
    height: 100%;
    width: 100%;
    object-fit: cover;
  }
  .carousel .card .h2 {
    font-weight: 500;
    font-size: 32px;
    font-family: "Roboto";
  }

  @media screen and (max-width: 900px) {
    .wrapper .carousel {
      grid-auto-columns: calc((100% / 2) - 9px);
    }
  }
  @media screen and (max-width: 600px) {
    .wrapper .carousel {
      grid-auto-columns: 100%;
    }
  }
</style>
