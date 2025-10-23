<template>
  <div class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 p-5 gap-4 rounded-2xl">
    <div
      v-for="(item, index) in promotionData"
      :key="item.id"
      :style="{ backgroundColor: item.backgroundColor }"
      class="relative w-full min-w-[768px]:w-[340px] xl:w-[480px] h-[300px] flex gap-4 xl:items-center p-5 xl:p-10 rounded-2xl"
    >
      <div
        :class="[
          'flex flex-col mt-5 ml-2 lg:mt-0 lg:ml-0 xl:ml-0 xl:mt-0',
          index === 1 || index === 2 ? 'gap-5 lg:gap-13 xl:gap-20' : 'gap-5 lg:gap-5 xl:gap-11.5',
        ]"
      >
        <h1 class="w-[250px] font-Quicksand font-bold text-xl lg:text-2xl leading-[30px]">
          {{ item.title }}
        </h1>
        <ButtonCategory :text="item.button.text" :bg-color="item.button.bgColor" />
      </div>
      <div
        :class="[
          'absolute xl:top-0 bottom-0 right-0 mt-10',
          index === 1 ? 'top-5 md:top-7 lg:top-4' : 'top-19 md:top-[28%] lg:top-10',
        ]"
      >
        <img
          :src="item.image"
          alt=""
          :class="[
            'object-contain',
            index === 1
              ? 'w-[180px] h-[250px] lg:w-[200px] lg:h-[250px] xl:w-[180px] xl:h-[250px]'
              : 'xl:w-[400px] xl:h-[300px]',
          ]"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import ButtonCategory from './ButtonCategory.vue'
const promotionData = ref([
  {
    id: 1,
    title: 'Everyday Fresh & Clean with Our Products',
    image: '/Image/Promotion/Vegetable2.png',
    backgroundColor: '#F0E8D5',
    button: {
      text: 'Shop Now',
      bgColor: '#3BB77E',
    },
  },
  {
    id: 2,
    title: 'Make your Breakfast Healthy and Easy',
    image: '/Image/Promotion/Stawberry.png',
    backgroundColor: '#F3E8E8',
    button: {
      text: 'Shop Now',
      bgColor: '#3BB77E',
    },
  },
  {
    id: 3,
    title: 'The best Organic Products Online',
    description: 'Enjoy free shipping on orders over $100.',
    image: '/Image/Promotion/Vegetable1.png',
    backgroundColor: '#E7EAF3',
    button: {
      text: 'Shop Now',
      bgColor: '#FDC040',
    },
  },
])
</script>
