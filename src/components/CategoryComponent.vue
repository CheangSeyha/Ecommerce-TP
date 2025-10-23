<template>
  <div class="w-full grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-10 gap-4 p-5">
    <div
      v-for="item in categoryData"
      :key="item.id"
      :style="{ backgroundColor: item.backgroundColor }"
      class="md:w-[168px] lg:w-[145px] h-[200px] xl:w-[136px] lg:h-[170px] xl:h-[177px] flex flex-col items-center justify-between rounded-2xl p-1"
    >
      <img
        :src="item.image"
        alt="Category Image"
        class="w-full h-[140px] lg:h-[120px] object-contain"
      />
      <div class="mb-4 text-center">
        <h3 class="text-sm font-semibold">{{ item.name }}</h3>
        <p class="text-xs text-gray-500 mt-1">{{ item.total }} items</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const categoryData = ref([
  {
    id: 1,
    name: 'Cake & Milk',
    image: '/Image/Category/1.png',
    total: 14,
    backgroundColor: '#F2FCE4',
  },
  {
    id: 2,
    name: 'Peach',
    image: '/Image/Category/2.png',
    total: 17,
    backgroundColor: '#FFFCEB',
  },
  {
    id: 3,
    name: 'Oganic Kiwi',
    image: '/Image/Category/3.png',
    total: 21,
    backgroundColor: '#ECFFEC',
  },
  {
    id: 4,
    name: 'Red Apple',
    image: '/Image/Category/4.png',
    total: 68,
    backgroundColor: '#FEEFEA',
  },
  {
    id: 5,
    name: 'Snack',
    image: '/Image/Category/5.png',
    total: 34,
    backgroundColor: '#FFF3EB',
  },
  {
    id: 6,
    name: 'Black plum',
    image: '/Image/Category/6.png',
    total: 25,
    backgroundColor: '#FFF3FF',
  },
  {
    id: 7,
    name: 'Vegetables',
    image: '/Image/Category/7.png',
    total: 65,
    backgroundColor: '#F2FCE4',
  },
  {
    id: 8,
    name: 'Headphone',
    image: '/Image/Category/8.png',
    total: 33,
    backgroundColor: '#FFFCEB',
  },
  {
    id: 9,
    name: 'Cake & Milk',
    image: '/Image/Category/9.png',
    total: 54,
    backgroundColor: '#F2FCE4',
  },
  {
    id: 10,
    name: 'Orange',
    image: '/Image/Category/10.png',
    total: 63,
    backgroundColor: '#FFF3FF',
  },
])
</script>
