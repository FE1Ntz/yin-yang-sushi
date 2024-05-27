<template>
    <div class="h-full flex flex-col bg-black dark:bg-white text-white dark:text-black rounded-lg p-5">
        <div class="flex justify-center bg-white dark:bg-black overflow-hidden product-card-img-aspect-ratio rounded-lg items-center">
            <img class="w-full h-auto h-min-[220px] max-w-[330px] rounded-md" :src="product.image" alt="sushi">
        </div>
        <div class="font-bold mt-2 text-[28px]">{{ product.name }}</div>
        <div class="mt-0.5">{{ product.weight }} г</div>
        <div class="mt-0.5">
            {{ product.ingredients.map((item) => item.name).join(', ') }}
        </div>
        <div class="flex mt-auto pt-4 justify-between">
            <div class="text-[23px] flex items-center font-bold">
                {{ formatPrice(product.price) }}
            </div>
            <div class="flex">
                <template v-if="showAddToFavorite">
                    <div class="quantity-container flex items-center gap-4">
                        <button @click="decrement" class="quantity-button bg-green-100 rounded-lg w-12 h-12 flex items-center justify-center text-green-500 text-xl">-</button>
                        <span class="text-xl">{{ quantity }}</span>
                        <button @click="increment" class="quantity-button bg-green-100 rounded-lg w-12 h-12 flex items-center justify-center text-green-500 text-xl">+</button>
                    </div>
                </template>
                <template v-else>
                    <button class="bg-white dark:bg-black rounded-md flex w-[48px] h-[48px] mr-2 justify-center px-2 items-center"
                            @click="likeProduct"
                    >
                        <img :src="'/icons/like/like-' + themeColor + '-' + isLiked + '.svg'" class="w-[25px] h-[25px]" alt="like">
                    </button>
                    <button @click="showAddToFavorite = !showAddToFavorite" class="bg-white dark:bg-black rounded-md flex w-[76px] h-[48px] justify-center px-2 items-center">
                        <img :src="'/icons/plus/plus-' + themeColor + '.svg'" alt="add">
                    </button>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import {formatPrice} from "@/Utils/utils.js";

export default {
    data(){
        return {
            showAddToFavorite: false,
            quantity: 1,
            isLiked: false,

        }
    },

    props: {
        themeColor: {
            type: String,
            default: "white",
            require: true,
        },

        product: {
            type: Object,
            required: true,
        },
    },

    methods: {
        formatPrice,
        likeProduct(){
            if(this.$page.props.auth.user){
                this.isLiked = !this.isLiked
                if (this.isLiked){
                    this.$toast.show('Продукт було додано до обраного!', 3000);
                }

                return;
            }

            this.$emit('onProductLiked',true);
        },

        increment() {
            this.quantity += 1;
        },

        decrement() {
            if (this.quantity > 1) {
                this.quantity -= 1;
            }
            else{
                this.showAddToFavorite = !this.showAddToFavorite
            }
        }
    }
}

</script>
