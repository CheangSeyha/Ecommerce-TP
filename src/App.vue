<script setup lang="ts">
import PromotionComponent from './components/PromotionComponent.vue'
import CategoryComponent from './components/CategoryComponent.vue'
import MenuComponent from './components/MenuComponent.vue'
import ProductList from './components/ProductList.vue'
import { computed, onMounted, ref } from 'vue'
import { useProductStore } from './stores/Products'
import NavBar from './components/ NavBar.vue'
import FooterE from './components/FooterE.vue'
import { type Products, type Categories, type Promotions } from './stores/Products'

const productStore = useProductStore()
const selectProductByGroup = ref<string>('All')
const selectCategoryByGroup = ref<string>('All')

const groups = computed(() => {
  return ['All', ...productStore.getGroup.filter((group) => group !== 'All')]
})

const promotions = computed<Promotions[]>(() => {
  return productStore.getAllPromotions
})

const filterByProducts = computed<Products[]>(() => {
  const allProducts = productStore.getAllProducts
  if (selectProductByGroup.value === 'All') {
    return allProducts
  }
  return productStore.getProductsByGroup(selectProductByGroup.value)
})

const filterByCategories = computed<Categories[]>(() => {
  const allCategoies = productStore.getAllCategories
  if (selectCategoryByGroup.value === 'All') {
    return allCategoies
  }
  return productStore.getCategoriesByGroup(selectCategoryByGroup.value)
})

const handleGroupSelectionProduct = (groupName: string) => {
  selectProductByGroup.value = groupName
}
const handleGroupSelectionCategory = (groupName: string) => {
  selectCategoryByGroup.value = groupName
}

onMounted(async () => {
  await productStore.fetchData()
  console.log('All Products', productStore.products)
  console.log('Group', productStore.groups)
  console.log('Promotions', productStore.promotions)
  console.log('Categories', productStore.categories)
})
</script>

<template>
  <header class="fixed top-0 left-0 w-full z-50">
    <NavBar />
  </header>
  <main class="flex flex-col mt-10">
    <section class="flex flex-row justify-between items-center mt-10 mb-5">
      <MenuComponent
        categories="Feature Categories"
        :groupName="groups"
        :selectedGroup="selectCategoryByGroup"
        @update-group="handleGroupSelectionCategory"
      />
    </section>
    <section>
      <CategoryComponent :categories="filterByCategories" />
    </section>
    <section>
      <PromotionComponent :promotions="promotions" />
    </section>
    <section class="flex flex-row justify-between items-center mt-10 mb-5">
      <MenuComponent
        categories="Popular Products"
        :groupName="groups"
        :selectedGroup="selectProductByGroup"
        @update-group="handleGroupSelectionProduct"
      />
    </section>
    <section>
      <ProductList :products="filterByProducts" />
    </section>
  </main>
  <footer class="w-full bg-gray-50 mt-10">
    <FooterE />
  </footer>
</template>
