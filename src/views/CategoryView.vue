<script setup lang="ts">
import NavBar from '@/components/ NavBar.vue'
import FooterE from '@/components/FooterE.vue'
import { useRoute } from 'vue-router'

const router = useRoute()
console.log('category view' + router.params.categoriesId)
</script>

<template>
  <div>
    <header class="fixed top-0 left-0 w-full z-50">
      <NavBar />
    </header>
    <main class="flex flex-col h-screen">
      <div>
        <h1 class="text-black text-center mt-40">Category View {{ $route.params.categoriesId }}</h1>
      </div>
    </main>
    <footer class="w-full bg-gray-50 mt-10">
      <FooterE />
    </footer>
  </div>
</template>
