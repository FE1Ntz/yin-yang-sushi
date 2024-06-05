<template>
     <header id="header">
         <div class="flex justify-between leading-5 text-[30px] text-black dark:text-white py-5 px-4">
             <div class="font-robotoMono">
                 <Link :href="route('index')">YIN&<br>YANG</Link>
             </div>
             <div class="flex  font-montserrat justify-end items-center">
                 <ThemeSwitch @themeColor="(value) => themeColor = value"/>
                 <div class="flex text-[17px]">
                     <div class="px-4">
                         <Link class="flex flex-col items-center" :href="route('index')">
                             <img :src="'/icons/home/home-' + themeColor +'.svg'" alt="SVG Icon">
                             <span>
                                Головна
                             </span>
                         </Link>
                     </div>
                     <div class="px-4">
                         <Link class="flex flex-col items-center" :href="route('menu')">
                             <img :src="'/icons/menu/menu-' + themeColor +'.svg'" alt="SVG Icon">
                             <span>
                                 Меню
                             </span>
                         </Link>
                     </div>
                     <div class="relative px-4">
                         <span v-if="cartItems > 0"
                               class="absolute top-[-10px] w-[30px] inline-flex justify-center right-[15px]
                                      px-2 py-1 text-sm dark:bg-white dark:text-black leading-none bg-black
                                      text-white rounded-full"
                         >
                            {{ cartItems }}
                         </span>
                         <div @click="goToCart" class="flex flex-col items-center">
                             <img :src="'/icons/shopping-cart/shopping-cart-' + themeColor +'.svg'" alt="SVG Icon">
                             <span>
                                 Кошик
                             </span>
                         </div>
                     </div>
                     <div v-if="$page.props.auth.user?.role === 'admin'" class="px-4">
                         <Link class="flex flex-col items-center" :href="route('admin.index')">
                             <img :src="'/icons/user/user-' + themeColor +'.svg'" alt="SVG Icon">
                             <span>
                                 Адмін
                             </span>
                         </Link>
                     </div>
                     <div v-else class="px-4">
                         <Link class="flex flex-col items-center" :href="$page.props.auth.user ? route('profile') : route('login')">
                             <img :src="'/icons/user/user-' + themeColor +'.svg'" alt="SVG Icon">
                             <span v-if="$page.props.auth.user">
                                 Профіль
                             </span>
                             <span v-else>
                                 Увійти
                             </span>
                         </Link>
                     </div>
                 </div>
             </div>
         </div>
         <div class="flex justify-center">
             <hr class="w-full h-[2px] border-none bg-black dark:bg-white">
         </div>
     </header>

     <!-- Page Content -->
    <slot :themeColor="themeColor" />

    <footer>
        <div class="flex w-full flex-col sm:flex-row items-center sm:justify-between border-t text-black dark:text-white border-black dark:border-white p-8">
            <div class="leading-9 mx-[20px] my-4 sm:my-0 flex items-center text-[50px] font-robotoMono">
                YIN&<br>YANG
            </div>
            <div class="flex mx-[20px] my-4 sm:my-0 flex-col font-robotoMono">
                <h1 class="font-bold">Контактні данні:</h1>
                <p>+380992155097</p>
                <p>+380443231781</p>
                <p>+380443777058</p>
            </div>
            <div class="flex mx-[20px] my-4 sm:my-0 flex-col font-robotoMono">
                <h1 class="font-bold">Місцезнаходження:</h1>
                <p>село Пілгайці <br> вул. Клечальна 5</p>
            </div>
        </div>
        <div class="w-full flex border-t border-black dark:border-white dark:text-white justify-center">© YIN&YANG. All rights reserved.</div>
    </footer>
</template>

<script>
import {goTo} from "@/Utils/utils.js";
import {router} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';
import {getCartItems} from "@/Utils/utils.js";
import ThemeSwitch from "@/Components/ThemeSwitch.vue";

export default {
    data() {
        return {
            themeColor: 'white',
            cartItems: 0,
        };
    },

    components: {
        ThemeSwitch,
        Link
    },

    created() {
        this.cartItems = getCartItems().reduce((accumulator, item) => accumulator + item.quantity, 0);
        this.$eventBus.on('onProductQuantityChanges', (quantity) => {this.cartItems += quantity});
        this.$eventBus.on('onOrderCreated', () => {this.cartItems = 0});
    },

    methods: {
        goToCart(){
            router.post(route('add-to-cart'), getCartItems(), {
                onSuccess: () => goTo(route('cart.index')),
            });
        }
    }
};
</script>

