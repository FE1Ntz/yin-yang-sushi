<template>
    <DefaultLayout v-slot="{ themeColor }">
        <div class="flex">
            <div class="p-4 flex-1 overflow-y-auto">
                <div class="flex flex-wrap justify-center mt-8">
                    <div v-for="category in categories" @click="selectedCategory = category.name"
                         class="m-2 font-montserrat dark:text-white text-[23px] border-b-2 border-black dark:border-white"
                    >
                        {{ category.name }}
                    </div>
                    <div @click="selectedCategory = 'allCategories'"
                         class="m-2 font-montserrat dark:text-white text-[23px] border-b-2 border-black dark:border-white"
                    >
                        Всі позиції
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="grid gap-[20px] 2xl:grid-cols-4 mt-12 lg:grid-cols-3 sm:grid-cols-2">
                        <Product v-for="product in products.filter((item) => item.category.name === selectedCategory || selectedCategory === 'allCategories')"
                                 :product="product"
                                 :themeColor="themeColor"
                                 @onProductLiked="(value) => showPleaseLoginModal = value"
                        />
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
import { goTo } from "@/Utils/utils.js";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import {category} from "@/models/customModels.js";
import Product from "@/Components/Product.vue";

export default {
    computed: {
        category() {
            return category
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
        };
    },

    mounted() {

    },

    methods: {
        goTo,
    },

}
</script>

