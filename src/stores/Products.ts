import axios from 'axios'
import { defineStore } from 'pinia'

export interface Categories {
  id: number
  name: string
  productCount: number
  color: string
  image: string
  groupName: string
}

export interface Promotions {
  id: number
  title: string
  buttonColor: string
  url: string
  color: string
  image: string
}

export interface Products {
  name: string
  rating: number
  size: string
  image: string
  price: number
  promotionAsPercentage: number
  categoryId: number
  instock: number
  countSold: number
  group: string
}

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

export const useProductStore = defineStore('products', {
  state: () => ({
    groups: [] as string[],
    promotions: [] as Promotions[],
    categories: [] as Categories[],
    products: [] as Products[],
  }),

  getters: {
    getGroup: (state) => {
      return state.groups
    },
    getAllProducts: (state) => {
      return state.products
    },

    getAllPromotions: (state) => {
      return state.promotions
    },

    getAllCategories: (state) => {
      return state.categories
    },
    getCategoriesByGroup: (state) => {
      return (groupName: string): Categories[] => {
        return state.categories.filter((category) => category.groupName === groupName)
      }
    },
    getProductsByGroup: (state) => {
      return (groupName: string): Products[] => {
        return state.products.filter((product) => product.group === groupName)
      }
    },

    getProductsByCategory: (state) => {
      return (id: number): Products[] => {
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
        const [groups, categories, products, promotions] = await Promise.all([
          axios.get(`${API_BASE_URL}api/groups`),
          axios.get(`${API_BASE_URL}api/categories`),
          axios.get(`${API_BASE_URL}api/products`),
          axios.get(`${API_BASE_URL}api/promotions`),
        ])

        this.groups = groups.data
        this.categories = categories.data
        this.products = products.data
        this.promotions = promotions.data
      } catch (error) {
        console.log(error)
      }
    },
  },
})
