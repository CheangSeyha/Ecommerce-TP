import axios from 'axios'
import { defineStore } from 'pinia'

interface Group {
  name: string
}

interface Categories {
  id: number
  name: string
  productCount: number
  color: string
  image: string
  groupName: string
}

interface Promotions {
  title: string
  buttonColor: string
  url: string
  color: string
  image: string
}

interface Products {
  name: string
  price: number
  color: string
  image: string
  groupName: string
  countSold: number
  categoryId: number
}

// ----- Store -----
export const useProductStore = defineStore('products', {
  state: () => ({
    groups: [] as Group[],
    promotions: [] as Promotions[],
    categories: [] as Categories[],
    products: [] as Products[],
  }),

  getters: {
    getCategoriesByGroup: (state) => {
      return (groupName: string): Categories[] => {
        const group = state.groups.find((group) => group.name === groupName)
        if (!group) return []
        return state.categories.filter((category) => category.groupName === groupName)
      }
    },
    getProductsByGroup: (state) => {
      return (groupName: string): Products[] => {
        const group = state.groups.find((group) => group.name === groupName)
        if (!group) return []
        return state.products.filter((product) => product.groupName === groupName)
      }
    },

    getProductsByCategory: (state) => {
      return (id: number): Products[] => {
        const category = state.categories.find((category) => category.id === id)
        if (!category) return []
        return state.products.filter((product) => product.categoryId === id)
      }
    },
    getPopularProducts: (state) => {
      return state.products.filter((product) => product.countSold > 10)
    },
  },

  actions: {
    async fetchData() {
      try {
        const [groupsResponse, categoriesResponse, productsResponse] = await Promise.all([
          axios.get('http://localhost:3000/api/groups'),
          axios.get('http://localhost:3000/api/categories'),
          axios.get('http://localhost:3000/api/promotions'),
          axios.get('http://localhost:3000/api/products'),
        ])

        this.groups = groupsResponse.data
        this.categories = categoriesResponse.data
        this.promotions = productsResponse.data
      } catch (error) {
        console.log(error)
      }
    },
  },
})
