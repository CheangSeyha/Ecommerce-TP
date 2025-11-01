<template>
  <div class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 p-5 gap-4 rounded-2xl">
    <div
      v-for="(item, index) in promotion"
      :key="item.id"
      :style="{ backgroundColor: item.color }"
      class="relative w-full xl:w-[450px] h-[300px] flex gap-4 xl:items-center p-5 xl:p-10 rounded-2xl"
    >
      <div
        :class="[
          'flex flex-col mt-5 ml-2 lg:mt-0 lg:ml-0',
          index === 1 || index === 2 ? 'gap-5 lg:gap-13 xl:gap-20' : 'gap-5 lg:gap-5 xl:gap-11.5',
        ]"
      >
        <h1 class="w-[250px] font-Quicksand font-bold text-xl lg:text-2xl leading-[30px]">
          {{ item.title }}
        </h1>
        <ButtonCategory :buttonColor="item.buttonColor" @click="shopNow(item)" />
      </div>

      <div
        :class="[
          'absolute xl:top-0 bottom-0 right-0 mt-10',
          index === 1 ? 'top-5 md:top-7 lg:top-4' : 'top-19 md:top-[28%] lg:top-10',
        ]"
      >
        <img
          :src="`http://localhost:3000/${item.image}`"
          :alt="item.title"
          :class="[
            'object-contain pointer-events-none',
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
import { ref, onMounted } from 'vue'
import ButtonCategory from './ButtonCategory.vue'
import axios from 'axios'

interface Promotion {
  id: number
  title: string
  color: string
  image: string
  url: string
  buttonColor: string
}

const promotion = ref<Promotion[]>([])
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const getPromotion = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/promotions`)
    promotion.value = response.data
    console.log(promotion.value)
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getPromotion()
})

const shopNow = (item: { title: string }) => {
  alert("Let's shop now! " + item.title)
}
</script>
