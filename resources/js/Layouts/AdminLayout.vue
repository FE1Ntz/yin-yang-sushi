<template>
    <div class="flex">
        <div class="w-[220px] border-r-2 border-black h-dvh flex flex-col text-black">
            <div class="flex leading-5 text-[30px] justify-center font-custom  mt-16">
                YIN&<br>YANG
            </div>
            <div class="flex mt-16 h-full flex-col">
                <div class="flex m-4">
                    <img :src="'/icons/orders/orders-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Замовлення</span>
                </div>
                <div class="flex m-4">
                    <img :src="'/icons/menu/menu-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Меню</span>
                </div>
                <div class="flex m-4">
                    <img :src="'/icons/analytics/analytics-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Аналітика</span>
                </div>
                <div class="flex m-4">
                    <img :src="'/icons/user/user-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Користувачі</span>
                </div>
                <div class="flex m-4">
                    <img :src="'/icons/settings/settings-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Налаштування</span>
                </div>
            </div>
            <Link :href="route('logout')" method="post" as="button">
                <div class="flex py-2 justify-center bg-red-500">
                    <img :src="'/icons/sign-out/sign-out-' + colorTheme +'.svg'" alt="SVG Icon">
                </div>
            </Link>
        </div>
        <slot/>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    components: {Link},
    data() {
        return {
            colorTheme: 'white'
        };
    },
};
</script>
