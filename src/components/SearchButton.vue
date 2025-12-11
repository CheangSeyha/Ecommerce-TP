<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

// --- 1. TYPES ---
interface FilterOption {
  id: string | number
  label: string
  checked: boolean
}

interface FilterGroup {
  key: string
  label: string
  options: FilterOption[]
}

// --- 2. DATA ---
const activeDropdown = ref<string | null>(null)

const filterGroups = ref<FilterGroup[]>([
  {
    key: 'All Categories',
    label: 'All Categories',
    options: [
      { id: 'cat-1', label: 'Residential', checked: false },
      { id: 'cat-2', label: 'Commercial', checked: false },
      { id: 'cat-3', label: 'Industrial', checked: false },
    ],
  },
])

// --- 3. LOGIC ---
const toggleDropdown = (key: string) => {
  activeDropdown.value = activeDropdown.value === key ? null : key
}

const closeAll = () => {
  activeDropdown.value = null
}

onMounted(() => document.addEventListener('click', closeAll))
onUnmounted(() => document.removeEventListener('click', closeAll))
</script>

<template>
  <div class="w-1/2 flex justify-center">
    <div
      class="relative flex items-center w-full max-w-4xl border border-green-300 rounded-md bg-white px-2 py-1 shadow-sm"
    >
      <div class="relative shrink-0">
        <div v-for="group in filterGroups" :key="group.key">
          <button
            @click.stop="toggleDropdown(group.key)"
            type="button"
            class="flex items-center gap-2 px-3 py-2 text-slate-800 font-bold hover:bg-gray-50 rounded transition-colors whitespace-nowrap"
          >
            {{ group.label }}
            <svg
              class="w-4 h-4 text-gray-500 transition-transform duration-200"
              :class="{ 'rotate-180': activeDropdown === group.key }"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
            </svg>
          </button>

          <div
            v-if="activeDropdown === group.key"
            @click.stop
            class="absolute top-full left-0 z-100 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl animate-fade-in"
          >
            <ul class="p-2 space-y-1">
              <li v-for="option in group.options" :key="option.id">
                <div class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                  <input
                    :id="`${group.key}-${option.id}`"
                    type="checkbox"
                    v-model="option.checked"
                    class="w-4 h-4 border-gray-300 rounded text-green-600 focus:ring-green-500 cursor-pointer"
                  />
                  <label
                    :for="`${group.key}-${option.id}`"
                    class="ms-2 text-sm font-medium text-gray-700 cursor-pointer w-full"
                  >
                    {{ option.label }}
                  </label>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="h-6 w-px bg-gray-300 mx-2"></div>

      <input
        type="text"
        placeholder="Search for items"
        class="flex-1 px-3 py-2 text-gray-700 placeholder-gray-400 bg-transparent border-none outline-none focus:ring-0"
      />

      <button class="p-2 text-gray-500 hover:text-green-600 transition-colors">
        <svg
          class="w-6 h-6"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
          />
        </svg>
      </button>
    </div>
  </div>
</template>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.15s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
