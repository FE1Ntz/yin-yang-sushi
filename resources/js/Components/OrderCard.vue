<template>
    <div class="mt-4 flex bg-black rounded-xl flex-col">
        <div class="flex justify-between items-center cursor-pointer py-0 px-5 min-h-[120px]">
            <div class="flex items-center">
                <div @click="showDetails = !showDetails" class="w-[34px] h-[34px] bg-white rounded-xl flex items-center justify-center mr-[32px]">
                    <img :class="[{ 'transform rotate-180': showDetails }, 'w-[20px] h-[20px]']" :src="'/icons/angle/angle-white.svg'" alt="">
                </div>
                <div class="flex-shrink-0 mr-5">
                    <div class="text-[#9e9e9e] text-[15px]">
                        {{ formatDate(order.created_at) }}
                    </div>
                    <div class="font-bold text-white text-[20px]">
                        # {{ order.id }}
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-5">
                    <div class="text-[#9e9e9e] text-[12px]">
                        Кількість
                    </div>
                    <div class="font-bold text-white text-[20px]">
                        {{ order.products.reduce((acc, obj) => {return acc + (obj.pivot.quantity || 0);}, 0) }}
                    </div>
                </div>
                <div class="mr-5">
                    <div class="text-[#9e9e9e] text-[12px]">
                        Загалом
                    </div>
                    <div class="font-bold text-white text-[20px]">
                        {{ formatPrice(order.price) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row sm:h-[65px] mb-3 text-white p-3">
            <div :class="[{ 'bg-white rounded-md text-black': order.status === 'Отримано' }, 'flex-1 flex items-center justify-center']">
                Отримано
            </div>
            <div :class="[{ 'bg-white rounded-md text-black': order.status === 'Готується' }, 'flex-1 flex items-center justify-center']">
                Готується
            </div>
            <div :class="[{ 'bg-white rounded-md text-black': order.status === 'Доставляється' }, 'flex-1 flex items-center justify-center']">
                Доставляється
            </div>
            <div :class="[{ 'bg-white rounded-md text-black': order.status === 'Виконано' }, 'flex-1 flex items-center justify-center']">
                Виконано
            </div>
            <div :class="[{ 'bg-white rounded-md text-black': order.status === 'Скасовано' }, 'flex-1 flex items-center justify-center']">
                Скасовано
            </div>
        </div>
        <div class="flex flex-col px-[48px] py-[12px]"
             v-if="showDetails"
        >
            <div class="flex flex-col text-white">
                <div class="flex">
                    <div>Час:</div>
                    <div class="flex-1 mx-2 border-b border-white border-dotted"/>
                    <div>{{ formatDate(order.created_at) }}</div>
                </div>
                <div class="flex">
                    <div>Спосіб оплати:</div>
                    <div class="flex-1 mx-2 border-b border-white border-dotted"/>
                    <div>{{ order.payment_method }}</div>
                </div>
                <div class="flex">
                    <div>Спосіб доставки:</div>
                    <div class="flex-1 mx-2 border-b border-white border-dotted"/>
                    <div>{{ order.delivery_way }}</div>
                </div>
                <div v-if="order.delivery_way === 'Доставка'" class="flex">
                    <div>Адреса:</div>
                    <div class="flex-1 mx-2 border-b border-white border-dotted"/>
                    <div>c. Підгайці вул. Клечальна 5</div>
                </div>
                <div v-if="order.delivery_way === 'В закладі'" class="flex">
                    <div>Місце в закдаді</div>
                    <div class="flex-1 mx-2 border-b border-white border-dotted"/>
                    <div>{{ order.table_id }}</div>
                </div>
                <div class="flex">
                    <div>До опалати:</div>
                    <div class="flex-1 mx-2 border-b border-white border-dotted"/>
                    <div>{{ formatPrice(order.price) }}</div>
                </div>
            </div>
            <div class="flex flex-col mt-5 text-white">
                <div v-for="product in order.products" class="flex-1 flex justify-between flex-wrap mb-3">
                    <div class="flex min-w-[275px]">
                        <div class="w-[98px] h-[65px] bg-white flex justify-center rounded-lg overflow-hidden">
                            <img :src="product.image" alt="">
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="ml-5">
                                <div class="font-bold text-white">
                                    {{ product.name }}
                                </div>
                                <div class="mt-2 text-[12px]">
                                    {{ product.weight }} г
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center min-w-[270px]">
                        <div class="flex-1">
                            <div class="text-[#9e9e9e] text-[12px]">
                                Ціна
                            </div>
                            <div class="font-bold text-white text-[20px]">
                                {{ formatPrice(product.pivot.price) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="text-[#9e9e9e] text-[12px]">
                                Кількість
                            </div>
                            <div class="font-bold text-white text-[20px]">
                                {{ product.pivot.quantity }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="text-[#9e9e9e] text-[12px]">
                                Загалом
                            </div>
                            <div class="font-bold text-white text-[20px]">
                                {{ formatPrice(product.pivot.price * product.pivot.quantity) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {formatDate} from "../Utils/utils.js";
    import {formatPrice} from  "../Utils/utils.js";

    export default {
        data(){
            return {
                showDetails: false,
            }
        },

        methods: {
            formatPrice,
            formatDate

        },

        props: {
            order: Object,
        }
    }
</script>
