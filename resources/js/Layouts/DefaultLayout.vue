<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
     <header>
         <div class="flex justify-between leading-5 font-custom text-[30px] text-black dark:text-white py-5 px-4">
             <div class="">
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
                     <li class="px-4"><Link :href="route('about-us')">About us</Link></li>
                     <li class="px-4"><Link :href="route('login')">Log in</Link></li>
                 </ul>
             </div>
         </div>
     </header>

     <!-- Page Content -->
     <main>
         <slot />
     </main>
</template>

<script>
export default {
    data() {
        return {
            isChecked: true,
        };
    },
    methods: {
        toggleChecked() {
            const htmlTag = document.querySelector('html');

            if (this.isChecked){
                htmlTag.classList.add('dark');
            }
            else{
                htmlTag.classList.remove('dark');
            }
            this.isChecked = !this.isChecked;
        }
    }
};
</script>

