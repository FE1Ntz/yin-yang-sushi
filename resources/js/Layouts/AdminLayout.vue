<template>
    <div class="flex h-dvh">
        <div :class="['border-r-2 border-black flex flex-col text-black transition-all duration-300 overflow-hidden', isCollapsed ? 'w-[80px]' : 'w-[220px]']">
            <div :class="['flex m-4', isCollapsed ? 'justify-center' : 'justify-end']"
                 @click="isCollapsed = !isCollapsed"
            >
                <img :src="'/icons/menu-burger/menu-burger-' + colorTheme +'.svg'" alt="SVG Icon">
            </div>
            <div class="flex leading-5 text-[30px] justify-center font-robotoMono mt-10">
                YIN&<br>YANG
            </div>
            <div class="flex mt-16 h-full flex-col">
                <Link :href="route('admin.index')">
                    <div :class="['flex m-4', isCollapsed ? 'justify-center': '']">
                        <img :src="'/icons/orders/orders-' + colorTheme +'.svg'" alt="SVG Icon">
                        <span v-if="!isCollapsed" class="ml-2">Замовлення</span>
                    </div>
                </Link>
                <Link :href="route('categories.index')">
                    <div :class="['flex m-4', isCollapsed ? 'justify-center': '']">
                        <img :src="'/icons/menu/menu-' + colorTheme +'.svg'" alt="SVG Icon">
                        <span v-if="!isCollapsed" class="ml-2">Категорії</span>
                    </div>
                </Link>
                <Link :href="route('ingredients.index')">
                    <div :class="['flex m-4', isCollapsed ? 'justify-center': '']">
                        <img :src="'/icons/menu/menu-' + colorTheme +'.svg'" alt="SVG Icon">
                        <span v-if="!isCollapsed" class="ml-2">Інгредієнти</span>
                    </div>
                </Link>
                <Link :href="route('products.index')">
                    <div :class="['flex m-4', isCollapsed ? 'justify-center': '']">
                        <img :src="'/icons/menu/menu-' + colorTheme +'.svg'" alt="SVG Icon">
                        <span v-if="!isCollapsed" class="ml-2">Продукти</span>
                    </div>
                </Link>
                <div :class="['flex m-4', isCollapsed ? 'justify-center': '']">
                    <img :src="'/icons/analytics/analytics-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span v-if="!isCollapsed" class="ml-2">Аналітика</span>
                </div>
                <div :class="['flex m-4', isCollapsed ? 'justify-center': '']">
                    <img :src="'/icons/user/user-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span v-if="!isCollapsed" class="ml-2">Користувачі</span>
                </div>
                <div :class="['flex m-4', isCollapsed ? 'justify-center': '']">
                    <img :src="'/icons/settings/settings-' + colorTheme +'.svg'" alt="SVG Icon">
                    <span v-if="!isCollapsed" class="ml-2">Налаштування</span>
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
            colorTheme: 'white',
            isCollapsed: true,
        };
    },
};
</script>
