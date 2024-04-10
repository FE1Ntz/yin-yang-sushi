<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
     <header id="header">
         <div class="flex justify-between leading-5 text-[30px] text-black dark:text-white py-5 px-4">
             <div class="font-custom">
                 <Link :href="route('index')">YIN&<br>YANG</Link>
             </div>
             <div class="flex text-[20px] justify-end items-center">
                 <label class="switch mx-4">
                     <input id="change-theme-input" type="checkbox">
                     <span @click="toggleChecked" id="change-theme-button" class="slider round"></span>
                 </label>
                 <div class="flex text-[17px]">
                     <div class="px-4">
                         <Link class="flex flex-col items-center" :href="route('index')">
                             <img :src="'/icons/home/home-' + colorTheme +'.svg'" alt="SVG Icon">
                             Home
                         </Link>
                     </div>
                     <div class="px-4">
                         <Link class="flex flex-col items-center" :href="route('index')">
                             <img :src="'/icons/menu/menu-' + colorTheme +'.svg'" alt="SVG Icon">
                             Menu
                         </Link>
                     </div>
                     <div class="px-4">
                         <Link class="flex flex-col items-center" href="/*route('shopping-cart')*/">
                             <img :src="'/icons/shopping-cart/shopping-cart-' + colorTheme +'.svg'" alt="SVG Icon">
                             Cart
                         </Link>
                     </div>
                     <div class="px-4">
                         <Link class="flex flex-col items-center" :href="route('login')">
                             <img :src="'/icons/user/user-' + colorTheme +'.svg'" alt="SVG Icon">
                             Log in
                         </Link>
                     </div>
                 </div>
             </div>
         </div>
     </header>

     <!-- Page Content -->

         <slot />


    <footer>
        asdfal;jsdhfl
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

