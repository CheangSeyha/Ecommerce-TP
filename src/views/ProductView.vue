<script setup lang="ts">
import NavBar from '@/components/layout/ NavBar.vue'
import FooterE from '@/components/layout/FooterE.vue'
import { useRoute } from 'vue-router'
import MenuCategories from '@/components/MenuCategories.vue'
import ProductDetail from '@/components/ProductDetail.vue'
import { useProductStore, type Products } from '@/stores/Products'
import { computed, onMounted } from 'vue'

const router = useRoute()
const productStore = useProductStore()

// FIXED: Fetch data if store is empty (handles page refresh)
onMounted(async () => {
  if (productStore.getAllProducts.length === 0) {
    await productStore.fetchData()
  }
})

const eachProduct = computed((): Products => {
  const id = parseInt(router.params.productsId as string)
  const allProducts = productStore.getAllProducts

  // Handle Loading State: if store is empty, return a placeholder
  if (allProducts.length === 0) {
    return {
      name: 'Loading...',
      rating: 0,
      size: '',
      image: '',
      price: 0,
      promotionAsPercentage: 0,
      categoryId: 0,
      instock: 0,
      countSold: 0,
      group: '',
    }
  }

  // Find product by index
  if (id >= 0 && id < allProducts.length) {
    const product = allProducts[id]
    if (product) {
      return product
    }
  }

  // Handle Not Found
  return {
    name: 'Not Found',
    rating: 0,
    size: '',
    image: '',
    price: 0,
    promotionAsPercentage: 0,
    categoryId: 0,
    instock: 0,
    countSold: 0,
    group: '',
  }
})
</script>

<template>
  <header class="fixed top-0 left-0 w-full z-50">
    <NavBar />
  </header>
  <main class="flex flex-col h-screen">
    <section>
      <MenuCategories />
    </section>
    <section class="mt-30 mb-20">
      <ProductDetail :product="eachProduct" />
    </section>
  </main>
  <footer class="w-full bg-gray-50 mt-50">
    <FooterE />
  </footer>
</template>
