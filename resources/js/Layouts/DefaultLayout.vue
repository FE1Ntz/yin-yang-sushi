<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
     <header id="header">
         <div class="flex justify-between leading-5 font-custom text-[30px] text-black dark:text-white py-5 px-4">
             <div>
                 YIN&<br>YANG
             </div>
             <div class="flex text-[20px] justify-end items-center">
                 <label class="switch mx-4">
                     <input id="change-theme-input" type="checkbox">
                     <span @click="toggleChecked" id="change-theme-button" class="slider round"></span>
                 </label>
                 <ul class="flex">
                     <li class="px-4"><Link :href="route('index')">Home</Link></li>
                     <li class="px-4"><Link :href="route('index')">Menu</Link></li>
                     <li class="px-4"><Link :href="route('login')"><img :src="'/icons/user/user-' + colorTheme +'.svg'" alt="SVG Icon"></Link></li>
                     <li class="px-4"><Link href="/*route('shopping-cart')*/"><img :src="'/icons/shopping-cart/shopping-cart-' + colorTheme +'.svg'" alt="SVG Icon"></Link></li>
                 </ul>
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

