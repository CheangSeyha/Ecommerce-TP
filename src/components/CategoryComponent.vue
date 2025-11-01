<template>
  <div class="w-full grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-10 gap-4 p-5">
    <div
      v-for="item in category"
      :key="item.id"
      :style="{ backgroundColor: item.color }"
      class="md:w-[168px] lg:w-[145px] h-[200px] xl:w-[122px] lg:h-[170px] xl:h-[177px] flex flex-col items-center justify-between rounded-2xl p-1"
    >
      <img
        :src="`${API_BASE_URL}${item.image}`"
        :alt="item.name"
        class="w-full h-[140px] lg:h-[120px] object-contain"
      />
      <div class="mb-4 text-center">
        <h3 class="text-sm font-semibold">{{ item.name }}</h3>
        <p class="text-xs text-gray-500 mt-1">{{ item.productCount }} items</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
interface Category {
  id: number
  name: string
  productCount: number
  color: string
  image: string
}

const category = ref<Category[]>([])
const getCategory = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}api/categories`)
    category.value = response.data
    console.log(category.value)
  } catch (error) {
    console.log(error)
  }
}
onMounted(() => {
  getCategory()
})
</script>
