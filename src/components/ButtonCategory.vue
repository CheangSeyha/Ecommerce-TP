<template>
  <button
    @click="$emit('click')"
    :style="{ backgroundColor: bgColor }"
    class="flex items-center cursor-pointer text-sm font-medium text-white w-fit px-4 md:px-6 py-1.5 rounded-[3px] z-10"
  >
    {{ text }} <i class="pi pi-arrow-right ml-2"></i>
  </button>
</template>

<script setup lang="ts">
defineProps<{
  text: string
  bgColor: string
}>()
defineEmits(['click'])
</script>
