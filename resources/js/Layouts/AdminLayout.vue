
<template>
    <div class="flex">
        <div class="w-[200px] border-r-2 border-black h-dvh flex flex-col text-black">
            <div class="flex leading-5 text-[30px] font-custom justify-center mt-16">
                YIN&<br>YANG
            </div>
            <div class="flex ml-2 mt-16 flex-col">
                <div class="flex m-2">
                    <img :src="'/icons/orders/orders-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Замовлення</span>
                </div>
                <div class="flex m-2">
                    <img :src="'/icons/menu/menu-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Меню</span>
                </div>
                <div class="flex m-2">
                    <img :src="'/icons/analytics/analytics-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Аналітика</span>
                </div>
                <div class="flex m-2">
                    <img :src="'/icons/user/user-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Користувачі</span>
                </div>
                <div class="flex m-2">
                    <img :src="'/icons/settings/settings-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span class="ml-2">Налаштування</span>
                </div>
            </div>
        </div>
    <slot />
    </div>
</template>

<script>
export default {
    data() {
        return {
            colorTheme: 'white'
        };
    },
};
</script>
