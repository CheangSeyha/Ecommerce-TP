<script setup lang="ts">
import { computed } from 'vue'
import NavBar from '@/components/layout/ NavBar.vue'
import FooterE from '@/components/layout/FooterE.vue'
import { useRoute } from 'vue-router'
import MenuCategories from '@/components/MenuCategories.vue'
import CategoryBanner from '@/components/CategoryBanner.vue'
import { useProductStore } from '@/stores/Products'

const router = useRoute()
const productStore = useProductStore()

const currentCategory = computed(() => {
  const id = router.params.categoriesId as string
  const category = productStore.getAllCategories.find((category) => category.id === parseInt(id))
  return category
})
</script>

<template>
  <div>
    <header class="fixed top-0 left-0 w-full z-50">
      <NavBar />
    </header>
    <main class="flex flex-col">
      <section>
        <MenuCategories />
      </section>

      <section>
        <CategoryBanner v-if="currentCategory" :nameCategory="currentCategory.name" />
      </section>
    </main>
    <footer class="w-full bg-gray-50 mt-10">
      <FooterE />
    </footer>
  </div>
</template>
