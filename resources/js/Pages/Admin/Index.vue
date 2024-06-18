<template>
    <AdminLayout>
        <div class="p-8 flex-1 overflow-y-auto">
            <div class="flex justify-between">
                <div class="font-bold font-montserrat text-[50px]">Замовлення</div>
<!--                <div class="flex items-center">
                </div>-->
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-black">
                    <thead>
                    <tr class="border border-black">
                        <th class="text-left p-4 border border-black">ID</th>
                        <th class="text-left p-4 border border-black">Ім'я</th>
                        <th class="text-left p-4 border border-black">Email</th>
                        <th class="text-left p-4 border border-black">Номер телефону</th>
                        <th class="text-left p-4 border border-black">Статус</th>
                        <th class="text-left p-4 border border-black">Спосіб доставки</th>
                        <th class="text-left p-4 border border-black">Спосіб оплати</th>
                        <th class="text-left p-4 border border-black">Ціна</th>
                        <th class="text-left p-4">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border border-black" v-for="order in orders" :key="order.id">
                        <td class="p-4 border border-black">{{ order.id }}</td>
                        <td class="p-4 border border-black">{{ order.name }}</td>
                        <td class="p-4 border border-black">{{ order.email }}</td>
                        <td class="p-4 border border-black">{{ order.phoneNumber }}</td>
                        <td class="p-4 border border-black">{{ order.status }}</td>
                        <td class="p-4 border border-black">{{ order.delivery_way }}</td>
                        <td class="p-4 border border-black">{{ order.payment_method }}</td>
                        <td class="p-4 border border-black">{{ formatPrice(order.price) }}</td>
                        <td class="p-4">
                            <div class="flex justify-around">
                                <button @click="openShowDetailsModal(order)" class="text-blue-600 hover:underline px-1">
                                    <img :src="'/icons/show/show-white.svg'" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="showDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg max-h-5/6 overflow-auto max-w-[990px] w-5/6">
                <h2 class="text-2xl mb-4">Деталі замовлення</h2>
                <form @submit.prevent="updateOrderDetails">
                    <div class="flex flex-wrap gap-[30px] overflow-y-auto max-h-[500px]">
                        <div class="flex-1 flex flex-col min-w-fit">
                            <label for="name">Ім'я:</label>
                            <input class="rounded-md
                                shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                focus:border-black focus:dark:border-white"
                                   type="text" id="name" v-model="form.name" required>

                            <label for="email">Email:</label>
                            <input type="email"
                                   class="rounded-md
                                shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                focus:border-black focus:dark:border-white"
                                   id="email" v-model="form.email" required>

                            <label for="phoneNumber">Номер телефону:</label>
                            <input type="tel"
                                   class="rounded-md
                                shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                focus:border-black focus:dark:border-white"
                                   id="phoneNumber" v-model="form.phoneNumber" required>
                        </div>

                        <div class="flex-1 flex flex-col min-w-fit">
                            <label for="status">Статус:</label>
                            <select class="rounded-md
                                shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                focus:border-black focus:dark:border-white"

                                id="status" v-model="form.status" required>
                                <option value="Отримано">Отримано</option>
                                <option value="Готується">Готується</option>
                                <option value="Доставляється">Доставляється</option>
                                <option value="Виконано">Виконано</option>
                                <option value="Скасовано">Скасовано</option>
                            </select>

                            <label for="deliveryWay">Спосіб доставки:</label>
                            <select id="deliveryWay"
                                    :class="[{'pointer-events-none opacity-40': form.status === 'Доставляється' || form.status === 'Виконано' || form.status === 'Скасовано'},
                                 'rounded-md shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white focus:border-black focus:dark:border-white']"
                                    v-model="form.delivery_way" required>
                                <option value="В закладі">В закладі</option>
                                <option value="Доставка">Доставка</option>
                                <option value="Самовивіз">Самовивіз</option>
                            </select>

                            <label for="paymentMethod">Спосіб оплати:</label>
                            <select id="paymentMethod" v-model="form.payment_method" required
                                    :class="[{'pointer-events-none opacity-40': form.status === 'Доставляється' || form.status === 'Виконано' || form.status === 'Скасовано'},
                                 'rounded-md shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white focus:border-black focus:dark:border-white']">
                                <option value="Готівка">Готівка</option>
                                <option value="Кредитна карта">Кредитна карта</option>
                            </select>
                        </div>

                        <div class="flex-1 flex flex-col min-w-fit">
                            <label for="price">Ціна:</label>
                            <input type="number"
                                   class="pointer-events-none opacity-40 rounded-md
                                shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                focus:border-black focus:dark:border-white"
                                   id="price" v-model="form.price" required>

                            <div class="flex flex-col" v-if="form.delivery_way === 'В закладі'">
                                <label for="price">Cтіл:</label>
                                <div class="flex gap-[10px]">
                                    <input type="number"
                                           class="pointer-events-none opacity-40 rounded-md
                                            shadow-sm dark:bg-[#252525] flex-1 focus:ring-black focus:dark:ring-white
                                            focus:border-black focus:dark:border-white"
                                           id="table" v-model="form.table_id" required
                                    >
                                    <button type="button" class="bg-black w-[41px] rounded-md flex justify-center items-center" @click="">
                                        <img :src="'/icons/pencil/pencil-dark.svg'" alt="">
                                    </button>
                                </div>
                            </div>

                            <label for="price">Дата:</label>
                            <input type="text"
                                   class="pointer-events-none opacity-40 rounded-md
                                            shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                            focus:border-black focus:dark:border-white"
                                   id="table" :value="formatDate(form.created_at)" required>
                        </div>
                        <div v-if="form.delivery_way === 'Доставка'" class="flex-1 flex flex-col min-w-fit">
                            <div class="flex flex-col">
                                <label for="price">Адреса:</label>
                                <input type="text"
                                       :class="[{'pointer-events-none opacity-40': form.status === 'Доставляється' || form.status === 'Виконано' || form.status === 'Скасовано'},
                                    'rounded-md shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white focus:border-black focus:dark:border-white']"
                                       id="table" v-model="form.address" required>
                            </div>
                            <label for="price">Початок доставки:</label>
                            <input type="text"
                                   class="pointer-events-none opacity-40 rounded-md
                                            shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                            focus:border-black focus:dark:border-white"
                                   id="table" v-model="form.startDelivery" required>

                            <label for="price">Кінець доставки:</label>
                            <input type="text"
                                   class="pointer-events-none opacity-40 rounded-md
                                            shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white
                                            focus:border-black focus:dark:border-white"
                                   id="table" v-model="form.finishDelivery" required>
                        </div>
                        <div class="flex flex-1 flex-col mt-5">
                            <div v-for="product in form.products" class="flex-1 flex justify-between flex-wrap mb-3">
                                <div class="flex min-w-[275px]">
                                    <div class="w-[98px] h-[65px] bg-white flex justify-center rounded-lg overflow-hidden">
                                        <img :src="product.image" alt="">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <div class="ml-5">
                                            <div class="font-bold">
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
                                        <div class="font-bold text-[20px]">
                                            {{ formatPrice(product.pivot.price) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-[#9e9e9e] text-[12px]">
                                            Кількість
                                        </div>
                                        <div class="font-bold text-[20px]">
                                            {{ product.pivot.quantity }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-[#9e9e9e] text-[12px]">
                                            Загалом
                                        </div>
                                        <div class="font-bold text-[20px]">
                                            {{ formatPrice(product.pivot.price * product.pivot.quantity) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 gap-[20px]">
                        <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">Оновити</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
<!--        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-1/3">
                <h2 class="text-2xl mb-4">Підтвердіть видалення</h2>
                <p>Ви впевнені, що хочете видалити категорію "{{ form.name }}"?</p>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                    <button type="button" @click="deleteCategory" class="bg-red-600 text-white px-4 py-2 rounded-md">Видалити</button>
                </div>
            </div>
        </div>-->
    </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {formatDate, formatPrice} from "@/Utils/utils.js";
import {router} from "@inertiajs/vue3";
import OrderCard from "@/Components/OrderCard.vue";

export default {

    data(){
      return {
          showDetailsModal: false,
          form: null,
      }
    },

    methods: {
        formatDate,
        formatPrice,
        openShowDetailsModal(obj){
            this.showDetailsModal = true;
            this.form = {...obj};
        },

        closeModal(){
            this.showDetailsModal = false;
            this.form = null;
        },

        updateOrderDetails(){
            console.log(this.form);
            router.put(route('order.update', this.form.id), this.form, {
                onSuccess: (data) => {
                    console.log(data);
                    this.closeModal();
                    this.$toast.show('Замовлення оновлено успішно!');
                },
                onError: (err) => {
                    console.log(err);
                    console.log(this.errors);
                },
            });
        }
    },
    props: {
      orders: Array,
    },
    components: {
        OrderCard, AdminLayout
    },

    mounted() {
        console.log(this.orders);
    }
}
</script>
