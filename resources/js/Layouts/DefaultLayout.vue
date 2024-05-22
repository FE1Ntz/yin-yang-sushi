<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
     <header id="header">
         <div class="flex justify-between leading-5 text-[30px] text-black dark:text-white py-5 px-4">
             <div class="font-robotoMono">
                 <Link :href="route('index')">YIN&<br>YANG</Link>
             </div>
             <div class="flex text-[20px font-montserrat justify-end items-center">
                 <label class="switch mx-4">
                     <input id="change-theme-input" type="checkbox">
                     <span @click="toggleChecked" id="change-theme-button" class="slider round"></span>
                 </label>
                 <div class="flex text-[17px]">
                     <div class="px-4">
                         <Link class="flex flex-col items-center" :href="route('index')">
                             <img :src="'/icons/home/home-' + colorTheme +'.svg'" alt="SVG Icon">
                             <span>
                                Головна
                             </span>
                         </Link>
                     </div>
                     <div class="px-4">
                         <Link class="flex flex-col items-center" :href="route('menu')">
                             <img :src="'/icons/menu/menu-' + colorTheme +'.svg'" alt="SVG Icon">
                             <span>
                                 Меню
                             </span>
                         </Link>
                     </div>
                     <div class="px-4">
                         <Link class="flex flex-col items-center" href="/*route('shopping-cart')*/">
                             <img :src="'/icons/shopping-cart/shopping-cart-' + colorTheme +'.svg'" alt="SVG Icon">
                             <span>
                                 Кошик
                             </span>
                         </Link>
                     </div>
                     <div v-if="$page.props.auth.user?.role === 'admin'" class="px-4">
                         <Link class="flex flex-col items-center" :href="route('admin.index')">
                             <img :src="'/icons/user/user-' + colorTheme +'.svg'" alt="SVG Icon">
                             <span>
                                 Адмін
                             </span>
                         </Link>
                     </div>
                     <div v-else class="px-4">
                         <Link class="flex flex-col items-center" :href="$page.props.auth.user ? route('profile') : route('login')">
                             <img :src="'/icons/user/user-' + colorTheme +'.svg'" alt="SVG Icon">
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
         <slot />

    <footer>

    </footer>
</template>

<script>
export default {
    data() {
        return {
            isChecked: false,
            colorTheme: 'white'
        };
    },
    methods: {
        toggleChecked() {
            const htmlTag = document.querySelector('html');

            this.isChecked = !this.isChecked;

            if (this.isChecked){
                htmlTag.classList.add('dark');
                this.colorTheme = 'dark';
            }
            else{
                htmlTag.classList.remove('dark');
                this.colorTheme = 'white';
            }
        }
    }
};
</script>

