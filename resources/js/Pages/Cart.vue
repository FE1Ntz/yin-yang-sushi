<template>
    <DefaultLayout>
        <div class="2xl:w-[1536px] mx-auto p-4 flex min-h-[600px] flex-wrap">
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
                        <tbody class="custom-scrollbar min-w-[450px]">
                        <tr v-for="item in cartItems" :key="item.id" class="border-b border-black">
                            <td class="py-2 w-[60%]">
                                <div class="flex items-center">
                                    <img :src="item.image" alt="Product Image" class="w-24 h-16 rounded-lg mr-4">
                                    <span>{{ item.name }}</span>
                                </div>
                            </td>
                            <td class="py-2 w-[30%]">{{ item.discounted_price }} грн</td>
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
                            <input type="text" id="name" required v-model="order.name" class="w-full border rounded px-2 py-1">
                        </div>
                        <div class="mb-4 w-full lg:w-1/2">
                            <label for="email" class="block text-gray-700">Електронна пошта</label>
                            <input type="email" id="email" required v-model="order.email" class="w-full border rounded px-2 py-1">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Номер телефону</label>
                        <input type="text" id="phone" required v-model="order.phoneNumber" class="w-full border rounded px-2 py-1">
                    </div>
                    <div class="flex flex-wrap gap-[20px]">
                        <div class="mb-4 min-w-[290px]">
                            <label for="inRestaurant" class="block text-gray-700">Спосіб отримання:</label>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio"
                                       name="deliveryWay"
                                       id="deliveryWayChoice1"
                                       value="В закладі"
                                       v-model="order.delivery_way"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice1" class="py-2 block text-gray-700">В ресторані</label>
                                <button v-if="order.delivery_way === 'В закладі'" type="button" class="bg-black text-white px-4 ml-8 py-2 rounded" @click.prevent="showRestaurantPlan = true">Вибрати місце</button>
                            </div>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="deliveryWay" id="deliveryWayChoice2" value="Доставка" v-model="order.delivery_way"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice2" class="py-2 block text-gray-700">Доставка</label>
                            </div>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="deliveryWay" id="deliveryWayChoice3" value="Самовивіз" v-model="order.delivery_way"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice3" class="py-2 block text-gray-700">Самовивіз</label>
                            </div>
                        </div>
                        <div class="mb-4 min-w-[250px]">
                            <label for="paymentCash" class="block text-gray-700">Спосіб оплати:</label>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="paymentMethod" id="paymentCash" value="Готівка" v-model="order.payment_method"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice2" class="py-2 block text-gray-700">Готівка</label>
                            </div>
                            <div class="flex items-center gap-[10px]">
                                <input type="radio" name="paymentMethod" id="paymentCredit" checked value="Кредитна карта" v-model="order.payment_method"
                                       class="ring-offset-0 text-black focus:ring-black"
                                >
                                <label for="deliveryWayChoice3" class="py-2 block text-gray-700">Картою</label>
                                <button v-if="order.payment_method === 'Кредитна карта'" type="button" class="bg-black text-white px-4 ml-8 py-2 rounded" @click.prevent="showCreditCardForm = true">Ввести данні</button>
                            </div>
                        </div>
                    </div>
                    <div v-if="order.delivery_way === 'Доставка'" class="mb-4">
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
                <Resturaunt v-if="order.delivery_way === 'В закладі'" />
                <div class="flex justify-end mt-4">
                    <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                    <button type="button" @click="bookTable" class="bg-black text-white px-4 py-2 rounded">Забронювати</button>
                </div>
            </div>
        </div>
        <div v-if="showCreditCardForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="max-w-lg mx-auto mt-10">
                <div class="bg-white rounded-lg px-8 pt-6 pb-8 mb-4">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="cardNumber">
                            Card Number
                        </label>
                        <input v-model="cardNumber" maxlength="16" @input="validate" pattern="\d{0,9}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cardNumber" type="text" placeholder="Enter your card number">
                    </div>
                    <div class="flex -mx-2">
                        <div class="w-1/2 px-2 mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="expiryDate">
                                Expiry Date
                            </label>
                            <input v-model="expiryDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="expiryDate" type="month" placeholder="MM/YY">
                        </div>
                        <div class="w-1/2 px-2 mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="cvv">
                                CVV
                            </label>
                            <input v-model="cvv" maxlength="3" @input="validate" pattern="\d{0,9}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cvv" type="text" placeholder="Enter CVV">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                        <button type="button" @click="submitForm" class="bg-black text-white px-4 py-2 rounded">Добавити</button>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>

import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import Resturaunt from "@/Components/Resturaunt.vue";
import {router} from "@inertiajs/vue3";

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
                phoneNumber: '',
                delivery_way: 'В закладі',
                payment_method: 'Кредитна карта',
                table_id: '9',
                products: [],
                price: 0,
            },
            showRestaurantPlan: false,
            showCreditCardForm: false,
            cardNumber: '',
            expiryDate: null,
            cvv: '',
        };
    },

    components: {
        DefaultLayout,
        Resturaunt,
    },

    computed: {
        totalPrice() {
            return this.cartItems.reduce((total, item) => total + item.discounted_price * item.quantity, 0);
        },
    },

    created() {
        console.log(this.products);
    },

    methods: {
        removeItem(item) {
            this.cartItems = this.cartItems.filter(i => i.id !== item.id);
        },

        bookTable(){
            this.order.table_id = '9';
            this.closeModal();
        },

        submitOrder() {
            this.price = this.cartItems.reduce((total, item) => total + item.discounted_price * item.quantity, 0);
            this.order.products = this.cartItems;
            router.post(route('store-order'), this.order, {
                onSuccess: () => {
                    sessionStorage.clear();
                    this.$eventBus.emit('onOrderCreated');
                    this.$toast.show('Замовлення оформлено успішно');
                }
            });
        },

        closeModal(){
            this.showRestaurantPlan = false;
            this.showCreditCardForm = false;
        },

        validate(event) {
            let value = event.target.value;
            event.target.value = value.replace(/[^0-9]/g, '');
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
