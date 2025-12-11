<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { type Products } from '@/stores/Products'

const props = defineProps<{
  product: Products
}>()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const convertImage = (image: string | string[] | undefined): string => {
  if (!image) return ''
  try {
    const imageStr = typeof image === 'string' ? image : Array.isArray(image) ? image[0] : ''
    if (!imageStr) return ''
    const pathImage = JSON.parse(imageStr)
    return `${API_BASE_URL}${pathImage}` || ''
  } catch {
    return typeof image === 'string' ? image : Array.isArray(image) ? image[0] || '' : ''
  }
}

const productData = computed(() => {
  if (!props.product || !props.product.name) {
    return {
      title: 'Product',
      price: 0,
      oldPrice: '0.00',
      rating: 0,
      reviewCount: 0,
      vendor: '',
      sku: '',
      stockStatus: 'Out of Stock',
      shortDesc: '',
      images: [] as string[],
    }
  }

  const productImage = props.product.image || ''
  const images = props.product.image || (productImage ? [productImage] : [])
  const convertedImages = (Array.isArray(images) ? images : [images])
    .map((img) => convertImage(img))
    .filter((img): img is string => Boolean(img))

  return {
    title: props.product.name || 'Product',
    price: props.product.price || 0,
    oldPrice: (props.product.price * 1.25).toFixed(2),
    vendor: 'Local Farm',
    sku: 'SKU-' + Math.floor(Math.random() * 10000),
    shortDesc:
      'This is a premium product sourced directly from the best providers. Fresh, organic, and ready for your kitchen.',
    reviewCount: 4,
    rating: props.product.rating || 0,
    stockStatus: (props.product.instock || 0) > 0 ? 'In Stock' : 'Out of Stock',
    images: convertedImages.length > 0 ? convertedImages : [],
  }
})

// Interactive State
const activeImage = ref<string>('')
const quantity = ref(1)
const activeTab = ref('description')

watch(
  () => productData.value.images,
  (newImages) => {
    if (newImages && newImages.length > 0) {
      activeImage.value = newImages[0] || ''
    }
  },
  { immediate: true },
)

const setMainImage = (imgUrl: string) => {
  if (imgUrl) {
    activeImage.value = imgUrl
  }
}

// FIXED: Added "|| ''" to handle TypeScript 'undefined' warning
const nextImage = () => {
  const images = productData.value.images
  if (images.length === 0) return
  const currentIndex = images.indexOf(activeImage.value)
  const nextIndex = (currentIndex + 1) % images.length
  // TypeScript safety: fallback to empty string if undefined
  activeImage.value = images[nextIndex] || ''
}

// FIXED: Added "|| ''" to handle TypeScript 'undefined' warning
const prevImage = () => {
  const images = productData.value.images
  if (images.length === 0) return
  const currentIndex = images.indexOf(activeImage.value)
  const prevIndex = (currentIndex - 1 + images.length) % images.length
  // TypeScript safety: fallback to empty string if undefined
  activeImage.value = images[prevIndex] || ''
}

const increaseQty = () => quantity.value++
const decreaseQty = () => {
  if (quantity.value > 1) quantity.value--
}

const addToCart = () => {
  alert(`Added ${quantity.value} item(s) to cart!`)
}
</script>

<template>
  <div class="w-full max-w-7xl mx-auto px-4 py-8 mt-10 font-sans text-gray-700">
    <nav class="text-sm text-gray-500 mb-8">
      <ul class="flex items-center space-x-2">
        <a href="/" class="hover:text-green-600 transition">Home</a>
        <li><span>&rsaquo;</span></li>
        <li>Vegetables & tubers</li>
        <li><span>&rsaquo;</span></li>
        <li class="text-green-600 font-medium">{{ productData.title }}</li>
      </ul>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
      <div class="flex flex-col">
        <div
          class="border rounded-2xl p-8 mb-4 relative flex items-center justify-center bg-white overflow-hidden h-[500px] border-gray-100 shadow-sm"
        >
          <img
            :src="activeImage"
            alt="Product Image"
            class="object-contain max-h-full max-w-full transition-transform duration-500 hover:scale-105"
          />
        </div>

        <div class="flex items-center gap-4 mt-2">
          <button
            @click="prevImage"
            class="h-10 w-10 flex items-center justify-center rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors shadow-sm flex-shrink-0"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
          </button>

          <div class="flex space-x-3 overflow-x-auto py-2 px-1 flex-1 scrollbar-hide">
            <div
              v-for="(img, index) in productData.images"
              :key="index"
              @click="setMainImage(img)"
              class="cursor-pointer border-2 rounded-xl p-1 w-20 h-20 flex-shrink-0 transition-all duration-200"
              :class="
                activeImage === img
                  ? 'border-green-500 shadow-md scale-105'
                  : 'border-gray-100 hover:border-green-300'
              "
            >
              <img :src="img" class="w-full h-full object-cover rounded-lg" />
            </div>
          </div>

          <button
            @click="nextImage"
            class="h-10 w-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors shadow-sm flex-shrink-0"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>

      <div class="flex flex-col justify-center">
        <span
          class="inline-block bg-green-100 text-green-600 px-3 py-1 rounded-md text-sm font-bold mb-4 w-fit"
        >
          {{ productData.stockStatus }}
        </span>

        <h1 class="text-4xl font-extrabold text-gray-800 mb-4 leading-tight">
          {{ productData.title }}
        </h1>

        <div class="flex items-center mb-6">
          <div class="flex text-yellow-400 text-sm">
            <span v-for="n in 5" :key="n">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 fill-current"
                :class="n <= Math.round(productData.rating) ? 'text-yellow-400' : 'text-gray-300'"
                viewBox="0 0 20 20"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </span>
          </div>
          <span class="text-xs text-gray-400 ml-2">({{ productData.reviewCount }} reviews)</span>
        </div>

        <div class="flex items-end gap-3 mb-6">
          <span class="text-5xl font-bold text-green-500">${{ productData.price }}</span>
          <span class="text-xl text-gray-300 line-through mb-2 font-medium"
            >${{ productData.oldPrice }}</span
          >
        </div>

        <p class="text-gray-500 mb-8 leading-relaxed text-base">
          {{ productData.shortDesc }}
        </p>

        <div class="flex items-center gap-3 mb-8">
          <div
            class="flex items-center border border-green-500 rounded-md h-12 w-24 px-3 bg-white relative"
          >
            <span class="text-green-600 font-bold text-lg flex-1 pl-1">{{ quantity }}</span>
            <div class="flex flex-col justify-center gap-[2px]">
              <button
                @click="increaseQty"
                class="text-green-600 hover:text-green-800 leading-none p-0.5"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-3 h-3"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="3"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
              </button>
              <button
                @click="decreaseQty"
                class="text-green-600 hover:text-green-800 leading-none p-0.5"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-3 h-3"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="3"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
            </div>
          </div>

          <button
            @click="addToCart"
            class="bg-green-500 hover:bg-green-600 text-white font-bold h-12 px-8 rounded-md shadow-sm flex items-center gap-2 transition-all transform active:scale-95"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
              />
            </svg>
            Add To Cart
          </button>

          <button
            class="h-12 w-12 border border-gray-200 rounded-md flex items-center justify-center text-gray-500 hover:border-green-500 hover:text-green-500 transition-colors bg-white shadow-sm"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
              />
            </svg>
          </button>

          <button
            class="h-12 w-12 border border-gray-200 rounded-md flex items-center justify-center text-gray-500 hover:border-green-500 hover:text-green-500 transition-colors bg-white shadow-sm"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"
              />
            </svg>
          </button>
        </div>
        <div class="grid grid-cols-2 gap-y-2 text-sm text-gray-500 w-full md:w-2/3">
          <span class="font-medium text-gray-400">Vendor:</span>
          <span class="text-green-600 font-medium">{{ productData.vendor }}</span>

          <span class="font-medium text-gray-400">SKU:</span>
          <span class="text-green-600 font-medium">{{ productData.sku }}</span>
        </div>
      </div>
    </div>

    <div class="mt-16 border rounded-2xl p-8 border-gray-100 shadow-sm bg-white">
      <div class="flex flex-wrap gap-4 mb-8 border-b border-gray-100 pb-1">
        <button
          @click="activeTab = 'description'"
          class="px-6 py-3 rounded-t-lg font-semibold transition-all relative top-[1px]"
          :class="
            activeTab === 'description'
              ? 'text-green-600 border-b-2 border-green-500'
              : 'text-gray-500 hover:text-green-600'
          "
        >
          Description
        </button>
        <button
          @click="activeTab = 'additional'"
          class="px-6 py-3 rounded-t-lg font-semibold transition-all relative top-[1px]"
          :class="
            activeTab === 'additional'
              ? 'text-green-600 border-b-2 border-green-500'
              : 'text-gray-500 hover:text-green-600'
          "
        >
          Additional info
        </button>
        <button
          @click="activeTab = 'reviews'"
          class="px-6 py-3 rounded-t-lg font-semibold transition-all relative top-[1px]"
          :class="
            activeTab === 'reviews'
              ? 'text-green-600 border-b-2 border-green-500'
              : 'text-gray-500 hover:text-green-600'
          "
        >
          Reviews ({{ productData.reviewCount }})
        </button>
      </div>

      <div class="text-gray-500 leading-relaxed text-sm animate-fade-in">
        <div v-if="activeTab === 'description'" class="space-y-4">
          <p>{{ productData.shortDesc }}</p>
          <p>
            This high-quality product comes directly from sustainable farms. It's carefully selected
            to ensure the best taste and nutrition for your family.
          </p>
        </div>
        <div v-if="activeTab === 'additional'">
          <ul class="list-disc pl-5 space-y-1">
            <li><strong>Type:</strong> Organic</li>
            <li><strong>Weight:</strong> 500g</li>
            <li><strong>Origin:</strong> {{ productData.vendor }}</li>
            <li><strong>Storage:</strong> Keep in a cool, dry place.</li>
          </ul>
        </div>
        <div v-if="activeTab === 'reviews'">
          <p class="italic text-gray-400">No reviews yet. Be the first to review!</p>
        </div>
      </div>
    </div>
  </div>
</template>
