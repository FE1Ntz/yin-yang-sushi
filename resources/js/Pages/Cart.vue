<template>
    <DefaultLayout>
        <div class="2xl:w-[1536px] mx-auto p-4 flex flex-wrap">
            <!-- Кошик -->
            <div class="w-full lg:w-1/2 p-4 h-auto">
                <h1 class="text-3xl font-bold mb-6">Ваш кошик</h1>
                <div v-if="cartItems.length" class="overflow-x-auto bg-white border border-black rounded-lg p-4">
                    <table class="w-full text-left">
                        <thead>
                        <tr class="border-b border-black">
                            <th class="py-2 w-[60%]">Товар</th>
                            <th class="py-2 w-[30%]">Ціна</th>
                            <th class="py-2 w-[30%]">Кількість</th>
                            <th class="py-2 w-[20px]"></th>
                        </tr>
                        </thead>
                        <tbody class="custom-scrollbar min-w-[450px]" @click="(event) => console.log(event)">
                        <tr v-for="item in cartItems" :key="item.id" class="border-b border-black">
                            <td class="py-2 w-[60%]">
                                <div class="flex items-center">
                                    <img :src="item.image" alt="Product Image" class="w-24 h-16 rounded-lg mr-4">
                                    <span>{{ item.name }}</span>
                                </div>
                            </td>
                            <td class="py-2 w-[30%]">{{ item.price }} грн</td>
                            <td class="py-2 w-[30%]">
                                <input type="number" min="1" v-model.number="item.quantity"
                                       class="w-16 border rounded px-2 py-1">
                            </td>
                            <td class="py-2 w-[20px]">
                                <div class="flex items-center justify-center">
                                    <button @click="removeItem(item)" class="text-red-500 hover:text-red-700">
                                        <img :src="'/icons/trash/trash-white.svg'" alt="">
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-end mt-6">
                        <div class="text-2xl font-bold">
                            Всього: {{ totalPrice }} грн
                        </div>
                    </div>
                </div>
                <div v-else class="text-center text-gray-500">
                    Ваш кошик порожній.
                </div>
            </div>

            <!-- Оформлення замовлення -->
            <div class="w-full lg:w-1/2 p-4 h-auto">
                <h1 class="text-3xl font-bold mb-6">Оформлення замовлення</h1>
                <form @submit.prevent="submitOrder" class="bg-white border border-black rounded-lg p-4">
                    <div class="flex gap-3">
                        <div class="mb-4 w-full lg:w-1/2">
                            <label for="name" class="block text-gray-700">Ім'я</label>
                            <input type="text" id="name" v-model="order.name" class="w-full border rounded px-2 py-1">
                        </div>
                        <div class="mb-4 w-full lg:w-1/2">
                            <label for="email" class="block text-gray-700">Електронна пошта</label>
                            <input type="email" id="email" v-model="order.email" class="w-full border rounded px-2 py-1">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Номер телефону</label>
                        <input type="text" id="phone" v-model="order.phone" class="w-full border rounded px-2 py-1">
                    </div>
                    <div class="flex gap-[20px]">
                        <div class="mb-4 min-w-[290px]">
                            <label for="inRestaurant" class="block text-gray-700">Спосіб отримання:</label>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio"
                                       name="deliveryWay"
                                       id="deliveryWayChoice1"
                                       value="inRestaurant"
                                       v-model="order.deliveryWay"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice1" class="py-2 block text-gray-700">В ресторані</label>
                                <button v-if="order.deliveryWay === 'inRestaurant'" type="button" class="bg-black text-white px-4 ml-8 py-2 rounded" @click.prevent="showRestaurantPlan = true">Вибрати місце</button>
                            </div>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="deliveryWay" id="deliveryWayChoice2" value="delivery" v-model="order.deliveryWay"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice2" class="py-2 block text-gray-700">Доставка</label>
                            </div>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="deliveryWay" id="deliveryWayChoice3" value="selfDelivery" v-model="order.deliveryWay"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice3" class="py-2 block text-gray-700">Самовивіз</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="paymentCash" class="block text-gray-700">Спосіб оплати:</label>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="paymentMethod" id="paymentCash" value="cash" v-model="order.paymentMethod"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice2" class="py-2 block text-gray-700">Готівка</label>
                            </div>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="paymentMethod" id="paymentCredit" value="credit" v-model="order.paymentMethod"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice3" class="py-2 block text-gray-700">Картою</label>
                            </div>


                        </div>
                    </div>
                    <div v-if="order.deliveryWay === 'delivery'" class="mb-4">
                        <label for="address" class="block text-gray-700">Адреса доставки</label>
                        <input type="text" id="address" v-model="order.address" class="w-full border rounded px-2 py-1">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded">Оформити замовлення</button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="showRestaurantPlan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-4 rounded-lg m-4 max-w-[600px]">
                <Resturaunt v-if="order.deliveryWay === 'inRestaurant'" />
                <div class="flex justify-end mt-4">
                    <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                    <button type="button" @click="deleteCategory" class="bg-black text-white px-4 py-2 rounded">Забронювати</button>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>

import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import Resturaunt from "@/Components/Resturaunt.vue";

export default {
    props: {
        products: Array,
    },

    data() {
        return {
            cartItems: [...this.products],
            order: {
                name: '',
                email: '',
                address: '',
                phone: '',
                deliveryWay: 'inRestaurant',
            },
            showRestaurantPlan: false
        };
    },

    components: {
        DefaultLayout,
        Resturaunt,
    },

    computed: {
        totalPrice() {
            return this.cartItems.reduce((total, item) => total + item.price * item.quantity, 0);
        },

        minTime() {
            let currentDate = new Date();
            let currentHours = currentDate.getHours();
            currentDate.setHours(currentHours + 1);
            let hours = String(currentDate.getHours()).padStart(2, '0');
            let minutes = String(currentDate.getMinutes()).padStart(2, '0');

            console.log(`${hours}:${minutes}`);

            return`${hours}:${minutes}`;
        },

        maxDate() {
            let currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 7);

            return  currentDate.toISOString().slice(0, currentDate.toISOString().lastIndexOf(':'));
        },
    },

    created() {
        console.log(this.products);
    },

    methods: {
        removeItem(item) {
            this.cartItems = this.cartItems.filter(i => i.id !== item.id);
        },
        submitOrder() {
            // Логіка для обробки замовлення
            alert('Замовлення оформлене!');
        },

        closeModal(){
            this.showRestaurantPlan = false;
        },
    },
};
</script>

<style scoped>
.container {
    max-width: 1200px;
}


.custom-scrollbar::-webkit-scrollbar {
    width: 12px; /* Ширина скролбара */
    height: 12px; /* Висота скролбара (для горизонтальної прокрутки) */
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    position: absolute;
    z-index: 10;
    background-color: darkgrey; /* Колір ползунка */
    border-radius: 10px; /* Радіус заокруглення ползунка */
    border: 3px solid transparent; /* Простір навколо ползунка */
    background-clip: content-box; /* Внутрішній кліп ползунка */
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1; /* Колір треку */
    border-radius: 10px; /* Радіус заокруглення треку */
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #555; /* Колір ползунка при наведенні */
}

tbody {
    display: block;
    max-height: 500px;
    overflow: auto;
}
thead, tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;/* even columns width , fix width of table too*/
}
</style>
