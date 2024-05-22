<template>
    <DefaultLayout>
        <div class="flex">
            <div class="p-4 flex-1 overflow-y-auto">
                <div class="flex flex-wrap justify-center mt-8">
                    <div v-for="category in categories" class="m-2 font-montserrat text-[23px] border-b-2">
                        {{ category.name }}
                    </div>
                    <div class="m-2 font-montserrat text-[23px] border-b-2">Всі позиції</div>
                </div>

                <div class="flex justify-center">
                    <div class="grid gap-[20px] 2xl:grid-cols-4 mt-12 lg:grid-cols-3 sm:grid-cols-2">
                        <div v-for="product in products" class="h-full flex flex-col bg-black rounded-lg p-5">
                            <div class="flex justify-center bg-white overflow-hidden product-card-img-aspect-ratio rounded-lg items-center">
                                <img class="w-full h-auto h-min-[220px] max-w-[330px] rounded-md" :src="product.image" alt="sushi">
                            </div>
                            <div class="text-white font-bold mt-2 text-[28px]">{{ product.name }}</div>
                            <div class="text-white mt-0.5">{{ product.weight }} г</div>
                            <div class="text-white mt-0.5">
                                {{ product.ingredients.map((item) => item.name).join(', ') }}
                            </div>
                            <div class="flex mt-auto pt-4 justify-between">
                                <div class="text-[23px] flex items-center text-white font-bold">
                                    {{ formatPrice(product.price) }}
                                </div>
                                <div class="flex">
                                    <button class="bg-white rounded-md flex w-[48px] h-[48px] mr-2 justify-center px-2 items-center">
                                        <img class="w-[25px] h-[25px]" :src="'/icons/like/like-' + colorTheme + '.svg'" alt="like">
                                    </button>
                                    <button class="bg-white rounded-md flex w-[76px] h-[48px] justify-center px-2 items-center">
                                        <img :src="'/icons/plus/plus-' + colorTheme + '.svg'" alt="add">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {formatPrice} from "../utils/utils.js";

export default {
    methods: {formatPrice},
    props: {
        categories: Array,
        products: Array,
    },

    components: {
        DefaultLayout,
    },

    data() {
        return {
            colorTheme: 'white'
        };
    },

    mounted() {
        console.log(this.products);
    },

}
</script>

