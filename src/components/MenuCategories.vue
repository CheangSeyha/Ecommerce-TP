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

interface NavItem {
  label: string
  hasDropdown?: boolean
  icon?: 'fire'
  link?: string
}

const showCategoryDropdown = ref(false)

// The data for the "Browse All Categories" dropdown content
const categoryGroups = ref<FilterGroup>({
  key: 'all-categories',
  label: 'Browse All Categories',
  options: [
    { id: 'cat-1', label: 'Milks and Dairies', checked: false },
    { id: 'cat-2', label: 'Wines & Alcohol', checked: false },
    { id: 'cat-3', label: 'Clothing & Beauty', checked: false },
    { id: 'cat-4', label: 'Pet Toy', checked: false },
  ],
})

// The main horizontal navigation menu items
const navMenu: NavItem[] = [
  { label: 'Hot Deals', icon: 'fire' },
  { label: 'Home' },
  { label: 'Food', hasDropdown: true },
  { label: 'Vegetables', hasDropdown: true },
  { label: 'Drink' },
  { label: 'Cookies' },
  { label: 'Meat & Seafood', hasDropdown: true },
  { label: 'Bakery' },
]

const toggleCategoryDropdown = () => {
  showCategoryDropdown.value = !showCategoryDropdown.value
}

const closeAll = (e: MouseEvent) => {
  const target = e.target as HTMLElement
  if (!target.closest('.category-dropdown-container')) {
    showCategoryDropdown.value = false
  }
}

onMounted(() => document.addEventListener('click', closeAll))
onUnmounted(() => document.removeEventListener('click', closeAll))
</script>

<template>
  <div class="w-full fixed top-20 right-0 left-0 z-50 bg-white border-b border-gray-200">
    <div class="w-full mx-auto px-4 md:px-6 py-3">
      <div class="flex flex-row justify-between items-center gap-4">
        <div class="flex flex-row items-center gap-6">
          <div class="relative category-dropdown-container shrink-0">
            <button
              @click.stop="toggleCategoryDropdown"
              type="button"
              class="flex items-center gap-2 bg-[#3BB77E] text-white px-5 py-3 rounded-[5px] font-bold text-sm hover:bg-[#2ea36d] transition-colors"
            >
              <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                ></path>
              </svg>

              <span>Browse All Categories</span>

              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>

            <div
              v-if="showCategoryDropdown"
              class="absolute top-full left-0 mt-2 w-64 bg-white border border-[#3BB77E] rounded-lg shadow-xl animate-fade-in z-50 overflow-hidden"
            >
              <ul class="py-2">
                <li v-for="option in categoryGroups.options" :key="option.id">
                  <div
                    class="flex items-center hover:bg-gray-50 px-4 py-2 cursor-pointer transition-colors"
                  >
                    <span class="text-sm font-medium text-gray-700">{{ option.label }}</span>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div
            class="hidden xl:flex flex-row items-center gap-6 text-[15px] font-bold text-[#253D4E]"
          >
            <div
              v-for="item in navMenu"
              :key="item.label"
              class="flex items-center gap-1 cursor-pointer hover:text-[#3BB77E] transition-colors whitespace-nowrap"
            >
              <svg
                v-if="item.icon === 'fire'"
                class="w-5 h-5 text-[#3BB77E]"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"
                />
              </svg>

              <span>{{ item.label }}</span>

              <svg
                v-if="item.hasDropdown"
                class="w-3 h-3 mt-0.5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-3 shrink-0 ml-auto xl:ml-0">
          <svg
            class="w-9 h-9 text-[#253D4E]"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
            <path
              d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"
            ></path>
          </svg>

          <div class="flex flex-col items-end xl:items-start leading-tight">
            <p class="text-[#3BB77E] text-2xl font-bold tracking-tight">099 777 888</p>
            <p class="text-[#7E7E7E] text-xs font-medium">24/7 Support Center</p>
          </div>
        </div>
      </div>
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
