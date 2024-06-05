<template>
    <DefaultLayout v-slot="{ themeColor }">
        <div class="flex">
            <div class="p-4 flex-1 overflow-y-auto">
                <div class="flex justify-between flex-col md:items-center md:flex-row 2xl:max-w-[1536px] 2xl:mx-auto mt-8">
                    <div class="flex flex-wrap">
                        <div @click="setCategory('allCategories')"
                             class="m-2 font-montserrat dark:text-white text-[23px] border-b-2 border-black dark:border-white"
                        >
                            Всі позиції
                        </div>
                        <div v-for="category in categories" @click="setCategory(category.id)"
                             class="m-2 font-montserrat dark:text-white text-[23px] border-b-2 border-black dark:border-white"
                        >
                            {{ category.name }}
                        </div>
                    </div>
                    <div class="m-2 min-w-[200px]">

                        <input class="rounded-md shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white focus:border-black focus:dark:border-white block w-full text-black dark:text-white"
                               @input="findByName"
                        >
                    </div>
                </div>
                <div v-if="filteredProducts.length > 0" class="2xl:max-w-[1536px] 2xl:mx-auto">
                    <div class="grid gap-[20px] grid-cols-fill mt-12">
                        <Product v-for="product in filteredProducts"
                                 :product="product"
                                 :themeColor="themeColor"
                                 :key="product.id"
                                 @onProductLiked="(value) => showPleaseLoginModal = value"
                        />
                    </div>
                </div>
                <div class="2xl:max-w-[1536px] font-montserrat dark:text-white 2xl:mx-auto min-h-[450px]" v-else>
                    <div class="flex items-center flex-col h-[450px] justify-center">
                        <img class="w-[60px] h-[60px] mb-8" :src="'/icons/filter-not-found/filter-not-found-' + themeColor + '.svg'" alt="">
                        Товарів не знайдено
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showPleaseLoginModal" id="pleaseLoginModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="bg-white p-8 mx-4 rounded-lg max-w-[500px]">
                <h1 class="font-bold text-[30px]">Увійдіть в обліковий запис</h1>
                <p class="text-[20px]">Для добавлення товарів в обране необхідно увійти в обліковий запис.</p>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="showPleaseLoginModal = false" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Пізніше</button>
                    <button type="button" @click="goTo(route('login'))" class="bg-blue-600 text-white px-4 py-2 rounded-md">Увійти</button>
                </div>
          </div>
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {goTo} from "@/Utils/utils.js";
import {category} from "@/models/customModels.js";
import Product from "@/Components/Product.vue";

export default {
    computed: {
        category() {
            return category
        },
        filteredProducts() {
            return this.products.filter((item) => {
                const isNameMatch = item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                const isCategoryMatch = item.category.id === this.selectedCategory || this.selectedCategory === 'allCategories';
                return isNameMatch && isCategoryMatch;
            });
        }
    },
    props: {
        categories: Array,
        products: Array,
    },

    components: {
        Product,
        DefaultLayout,
    },

    data() {
        return {
            showPleaseLoginModal: false,
            selectedCategory: 'allCategories',
            searchQuery: '',
        };
    },

    mounted() {

    },

    methods: {
        goTo,
        setCategory(categoryId) {
            this.selectedCategory = categoryId;
        },
        findByName(event) {
            this.searchQuery = event.target.value;
        },
    },
}
</script>

