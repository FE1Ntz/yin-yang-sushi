<template>
    <div class="h-full flex flex-col relative bg-black dark:bg-white text-white dark:text-black rounded-lg p-5">
        <div v-if="product.discount > 0" class="bg-red-700 top-[10px] left-[10px] p-1 rounded-lg text-white absolute">{{ product.discount }} %</div>
        <div class="flex justify-center bg-white dark:bg-black overflow-hidden rounded-lg items-center">
            <img class="max-w-[330px] h-[220px] rounded-md" :src="product.image" alt="sushi">
        </div>
        <div class="font-bold mt-2 text-[28px]">{{ product.name }}</div>
        <div class="mt-0.5">{{ product.weight }} г</div>
        <div class="mt-0.5">
            {{ product.ingredients.map((item) => item.name).join(', ') }}
        </div>
        <div class="flex mt-auto pt-4 justify-between">
            <div class="text-[23px] flex items-center font-bold">
                {{ formatPrice(product.discounted_price) }}
            </div>
            <div class="flex">
                <template v-if="quantity >= 1">
                    <div class="quantity-container flex items-center gap-4">
                        <button @click="decrement(product)" class="bg-white dark:bg-black rounded-md flex w-[48px] h-[48px] justify-center px-2 items-center">
                            <img :src="'/icons/minus/minus-' + themeColor + '.svg'" alt="add">
                        </button>
                        <span class="text-xl">
                            {{ quantity }}
                        </span>
                        <button @click="increment(product)" class="bg-white dark:bg-black rounded-md flex w-[48px] h-[48px] justify-center px-2 items-center">
                            <img :src="'/icons/plus/plus-' + themeColor + '.svg'" alt="add">
                        </button>
                    </div>
                </template>
                <template v-else>
                    <button class="bg-white dark:bg-black rounded-md flex w-[48px] h-[48px] mr-2 justify-center px-2 items-center"
                            @click="likeProduct"
                    >
                        <img :src="'/icons/like/like-' + themeColor + '-' + isLiked + '.svg'" class="w-[25px] h-[25px]" alt="like">
                    </button>
                    <button @click="increment(product)" class="bg-white dark:bg-black rounded-md flex w-[76px] h-[48px] justify-center px-2 items-center">
                        <img :src="'/icons/plus/plus-' + themeColor + '.svg'" alt="add">
                    </button>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import {setCartItemQuantity, formatPrice, getCartItems} from "@/Utils/utils.js";

export default {
    data(){
        return {
            quantity: 0,
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

    mounted() {
        let item = getCartItems().filter((item) => item.id === this.product.id)[0];
        if(item !== undefined){
            this.quantity = item.quantity;
        }
    },

    methods: {
        formatPrice,
        likeProduct(){
            if(this.$page.props.auth.user){
                this.isLiked = !this.isLiked
                if (this.isLiked){
                    this.$toast.show('Продукт було додано до обраного!');
                }

                return;
            }

            this.$emit('onProductLiked',true);
        },

        increment(product) {
            this.quantity += 1;
            this.$eventBus.emit('onProductQuantityChanges', 1);
            setCartItemQuantity(product, this.quantity);
            if (this.quantity === 1){
                this.$toast.show('Продукт було додано до корзини!');
            }
        },

        decrement(product) {
            this.quantity -= 1;
            if (this.quantity === 0) {
                this.$toast.show('Продукт було вилучено з корзини!');
            }

            setCartItemQuantity(product, this.quantity);
            this.$eventBus.emit('onProductQuantityChanges', -1);
        },
    }
}

</script>
