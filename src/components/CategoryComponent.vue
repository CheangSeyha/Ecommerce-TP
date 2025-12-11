<script setup lang="ts">
import { type Categories } from '@/stores/Products'

defineProps<{
  categories: Categories[]
}>()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
</script>

<template>
  <div
    class="w-full grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-10 cursor-pointer gap-4 p-5"
  >
    <div
      v-for="item in categories"
      :key="item.id"
      :style="{ backgroundColor: item.color }"
      @click="$router.push({ name: 'categories', params: { categoriesId: item.id } })"
      class="md:w-[168px] lg:w-[145px] h-[200px] xl:w-full lg:h-[170px] xl:h-[250px] flex flex-col items-center justify-between rounded-2xl p-1"
    >
      <img
        :src="`${API_BASE_URL}${item.image}`"
        :alt="item.name"
        class="w-full h-[140px] lg:h-[180px] object-contain"
      />
      <div class="mb-4 text-center">
        <h3 class="text-sm font-semibold">{{ item.name }}</h3>
        <p class="text-xs text-gray-500 mt-1">{{ item.productCount }} items</p>
      </div>
    </div>
  </div>
</template>
