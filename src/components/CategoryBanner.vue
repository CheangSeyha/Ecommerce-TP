<script setup lang="ts">
defineProps<{
  nameCategory: string
}>()
</script>
<template>
  <div class="relative w-full mx-auto">
    <img src="/Image/CategoryBanner.png" alt="banner" class="w-full" />
    <div class="absolute w-full inset-0 bg-[#3BB77E33]"></div>
    <div class="absolute top-1/2 flex items-center w-full px-12">
      <div class="flex flex-col gap-10 w-full max-w-3xl z-10 relative">
        <div class="flex flex-col gap-5">
          <h1 class="text-6xl md:text-7xl font-bold leading-tight text-[#253D4E]">
            {{ nameCategory }}
          </h1>
          <div class="flex flex-row gap-2">
            <a class="text-2xl text-[#7E7E7E] font-light" href="/">Home</a>
            <p class="text-2xl text-[#7E7E7E] font-light">/</p>
            <p class="text-2xl text-[#7E7E7E] font-light">Category</p>
            <p class="text-2xl text-[#7E7E7E] font-light">/</p>
            <p class="text-2xl text-[#7E7E7E] font-light">{{ nameCategory }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
