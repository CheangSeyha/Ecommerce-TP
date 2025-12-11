<script setup lang="ts">
import { Plus } from 'lucide-vue-next'
import { type Products } from '@/stores/Products'
import { ref } from 'vue'

defineProps<{
  products: Products[]
}>()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
const convertImage = (Image: string) => {
  const pathImage = JSON.parse(Image)
  return `${API_BASE_URL}${pathImage}`
}

const productQuantities = ref(new Map<string, number>())

const addItemToCart = (productName: string) => {
  productQuantities.value.set(productName, 1)
}

const updateQuantity = (productName: string, event: Event) => {
  const value = parseInt((event.target as HTMLInputElement).value, 10)

  if (value > 0) {
    productQuantities.value.set(productName, value)
  } else {
    productQuantities.value.delete(productName)
  }
}

const isProductAdded = (productName: string) => {
  return productQuantities.value.has(productName)
}
</script>

<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 px-6 py-4">
    <div
      class="relative w-full max-w-sm bg-white p-6 rounded-2xl border-2 border-gray-200 hover:border-green-300 shadow-xs flex flex-col items-center justify-end"
      v-for="(item, index) in products"
      :key="item.name"
    >
      <div class="absolute top-5 left-0 bg-green-400 w-20 h-10 rounded-r-full text-white">
        <span class="flex justify-center items-center h-full">
          -{{ item.promotionAsPercentage }}%
        </span>
      </div>

      <router-link :to="`/products/${index}`">
        <img :src="convertImage(item.image)" :alt="item.name" />
      </router-link>

      <div class="flex flex-col">
        <span class="text-sm text-gray-400">Hodo Food</span>
        <a href="#">
          <h5 class="text-xl text-heading font-semibold tracking-tight">
            {{ item.name }}
          </h5>
        </a>
        <div class="flex items-center space-x-3 mb-2 mt-2">
          <div class="flex items-center space-x-1">
            <svg
              v-for="i in 5"
              :key="i"
              class="w-5 h-5"
              :class="i <= Math.round(item.rating) ? 'text-yellow-400' : 'text-gray-400'"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
              />
            </svg>
          </div>
          <span class="text-sm text-gray-400 font-medium px-1.5 py-0.5 rounded-sm">{{
            item.rating
          }}</span>
        </div>
        <span class="text-base text-gray-400">{{ item.size }}</span>
        <div class="flex items-center justify-between mt-4">
          <div class="flex flex-row items-center gap-2">
            <span class="text-3xl font-extrabold text-green-400"
              >${{ item.price * (1 - item.promotionAsPercentage / 100) }}</span
            >
            <span class="text-lg font-light text-gray-400 line-through"
              >${{ item.promotionAsPercentage }}</span
            >
          </div>

          <button
            type="button"
            @click="addItemToCart(item.name)"
            v-if="!isProductAdded(item.name)"
            class="inline-flex items-center text-green-600 bg-green-200 leading-5 rounded-[4px] text-sm font-medium px-6 py-2.5"
          >
            Add <Plus class="w-4 h-4 ml-1 text-green-600" />
          </button>

          <div
            v-else
            class="inline-flex items-center bg-green-200 leading-5 rounded-[4px] text-sm font-medium"
          >
            <input
              type="number"
              :value="productQuantities.get(item.name)"
              @input="updateQuantity(item.name, $event)"
              min="0"
              class="text-green-600 text-center text-sm bg-transparent w-20 py-2.5 outline-none focus:ring-2 focus:ring-green-400 rounded-[4px]"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
