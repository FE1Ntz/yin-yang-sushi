<template>
    <DefaultLayout v-slot="{ themeColor }">
        <div class="min-h-[700px] max-w-[1536px] mx-auto px-8 my-10">
            <div class="flex flex-col lg:flex-row">
                <div class="w-full lg:w-[246px]">
                    <div class="flex flex-row flex-wrap lg:flex-col gap-[12px]">
                        <div :class="[{'bg-black text-white dark:text-black dark:bg-white': activeTab === 'orderHistory'},
                                'min-w-fit flex-1 flex items-center rounded-xl py-[10px] px-[12px] cursor-pointer']"
                             @click="setActiveTab('orderHistory')"
                        >
                            <div class="w-[46px] h-[46px] bg-white rounded-xl flex items-center justify-center mr-[12px]">
                                <img class="w-[25px] h-[25px]" :src="'/icons/order-history/order-history-white.svg'" alt="">
                            </div>
                            Історія замовлень
                        </div>
                        <div :class="[{'bg-black text-white dark:text-black dark:bg-white': activeTab === 'deliveryAddress'},
                                'min-w-fit flex-1 flex items-center rounded-xl py-[10px] px-[12px] cursor-pointer']"
                             @click="setActiveTab('deliveryAddress')"
                        >
                            <div class="w-[46px] h-[46px] bg-white rounded-xl flex items-center justify-center mr-[12px]">
                                <img class="w-[25px] h-[25px]" :src="'/icons/address/address-white.svg'" alt="">
                            </div>
                            Адреси доставки
                        </div>
                        <div :class="[{'bg-black text-white dark:text-black dark:bg-white': activeTab === 'favoritePositions'},
                                'min-w-fit flex-1 flex items-center rounded-xl py-[10px] px-[12px] cursor-pointer']"
                             @click="setActiveTab('favoritePositions')"
                        >
                            <div class="w-[46px] h-[46px] bg-white rounded-xl flex items-center justify-center mr-[12px]">
                                <img class="w-[25px] h-[25px]" :src="'/icons/like/like-white-false.svg'" alt="">
                            </div>
                            Улюблені позиції
                        </div>
                        <div :class="[{'bg-black text-white dark:text-black dark:bg-white': activeTab === 'settings'},
                                'min-w-fit flex-1 flex items-center rounded-xl py-[10px] px-[12px] cursor-pointer']"
                             @click="setActiveTab('settings')"
                        >
                            <div class="w-[46px] h-[46px] bg-white rounded-xl flex items-center justify-center mr-[12px]">
                                <img class="w-[25px] h-[25px]" :src="'/icons/settings/settings-' + themeColor + '.svg'" alt="">
                            </div>
                            Налаштування
                        </div>
                    </div>
                </div>
                <div class="lg:ml-[48px] flex-1">
                    <div v-if="activeTab === 'orderHistory'"
                         class="flex flex-col"
                    >
                        <h1 class="text-[calc(1.425rem+1.4vw)] mb-8 font-bold leading-[133%]">Історія замовлень</h1>
                        <div class="flex flex-wrap">
                            <div class="bg-black w-[120px] flex justify-center items-center text-white rounded-xl p-3 mr-3">Всі</div>
                            <div class="bg-black w-[120px] flex justify-center items-center text-white rounded-xl p-3 mr-3">Отримано</div>
                            <div class="bg-black w-[120px] flex justify-center items-center text-white rounded-xl p-3 mr-3">Готується</div>
                            <div class="bg-black w-[120px] flex justify-center items-center text-white rounded-xl p-3 mr-3">Доставляється</div>
                            <div class="bg-black w-[120px] flex justify-center items-center text-white rounded-xl p-3 mr-3">Виконано</div>
                            <div class="bg-black w-[120px] flex justify-center items-center text-white rounded-xl p-3 mr-3">Скасовано</div>
                        </div>
                        <OrderCard
                            v-for="order in orders"
                            :order="order"
                        />
                    </div>
                    <div v-if="activeTab === 'deliveryAddress'"
                         class="flex flex-col"
                    >
                        <div class="flex items-center justify-between">
                            <h1 class="text-[calc(1.425rem+1.4vw)] font-bold leading-[133%]">Адреси доставки</h1>
                            <button @click="showAddModal = true"
                                    class="py-2 px-3 bg-black text-white flex items-center rounded-xl">
                                Нова адреса
                                <img class="bg-white p-1 ml-2 rounded-md w-[20px] h-[20px]" :src="'/icons/plus/plus-white.svg'" alt="">
                            </button>
                        </div>

                        <div v-for="userAddress in userAddresses" class="flex bg-black text-white items-center px-4 rounded-xl justify-between h-[55px] mt-5">
                            <div>{{userAddress.address}}</div>
                            <div class="flex">
                                <div class="mr-2">
                                    <div @click="openEditModal(userAddress)" class="bg-white w-[34px] h-[34px] flex rounded-md cursor-pointer justify-center items-center">
                                        <img :src="'/icons/pencil/pencil-white.svg'" alt="">
                                    </div>
                                </div>
                                <div @click="openDeleteModal(userAddress)" class="bg-white w-[34px] h-[34px] flex rounded-md cursor-pointer justify-center items-center">
                                    <img :src="'/icons/trash/trash-white.svg'" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="activeTab === 'favoritePositions'"
                         class="flex flex-col"
                    >
                        <h1 class="text-[calc(1.425rem+1.4vw)] font-bold leading-[133%]">Улюблені позиції</h1>
                        <div>
                            <div class="grid gap-[20px] grid-cols-fill mt-12">
                                <Product v-for="product in likedProducts"
                                         :product="product"
                                         :theme-color="themeColor"
                                         :key="product.id"
                                />
                            </div>
                        </div>
                    </div>
                    <div v-if="activeTab === 'settings'"
                         class="flex flex-col"
                    >
                        <div class="flex items-center justify-between">
                            <h1 class="text-[calc(1.425rem+1.4vw)] font-bold leading-[133%]">Налаштування</h1>
                            <div class="flex items-center rounded-xl cursor-pointer">
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class=""
                                >Вийти з акаунту</Link>
                            </div>
                        </div>

                        <div class="flex flex-wrap mt-3 gap-[30px]">
                            <UpdateProfileInformationForm
                                class="min-w-fit flex-1"
                            />
                            <UpdatePasswordForm
                                class="min-w-fit flex-1"
                            />
                            <DeleteUserForm
                                class="min-w-fit flex-1"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-1/3">
                <h2 class="text-2xl mb-4">{{ showAddModal ? 'Додати адресу' : 'Редагувати адресу' }}</h2>
                <form @submit.prevent="showAddModal ? addNewAddress() : updateAddress()">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Адреса</label>
                        <input type="text"
                               v-model="addressForm.address"
                               id="name"
                               class="rounded-md shadow-sm dark:bg-[#252525] focus:ring-black focus:dark:ring-white focus:border-black focus:dark:border-white block w-full text-black dark:text-white"
                        >
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">{{ showAddModal ? 'Додати' : 'Оновити' }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-1/3">
                <h2 class="text-2xl mb-4">Підтвердіть видалення</h2>
                <p>Ви впевнені, що хочете видалити адресу "{{ addressForm.address }}"?</p>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                    <button type="button" @click="deleteAddress" class="bg-red-600 text-white px-4 py-2 rounded-md">Видалити</button>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import OrderCard from "@/Components/OrderCard.vue";
import {Link, router} from "@inertiajs/vue3";
import Product from "@/Components/Product.vue";
import {goTo} from "@/Utils/utils.js";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
export default {

    data(){
      return{
          activeTab: "orderHistory",
          showAddModal: false,
          showEditModal: false,
          showDeleteModal: false,
          addressForm: { address: ''},
      };
    },

    props: {
        userAddresses: Array,
        likedProducts: Array,
        orders: Array,
    },

    components: {
        DeleteUserForm,
        UpdatePasswordForm,
        UpdateProfileInformationForm,
        Link,
        Product,
        DefaultLayout,
        OrderCard
    },

    mounted() {
        console.log(this.orders);
    },

    methods: {
        goTo,
        setActiveTab(tab) {
            this.activeTab = tab;
        },

        closeModal(){
            this.showAddModal = false;
            this.showEditModal = false;
            this.showDeleteModal = false;
            this.addressForm = { address: ''};
        },

        openEditModal(userAddress){
            this.addressForm = {...userAddress};
            this.showEditModal = true;
        },

        addNewAddress(){
            router.post(route('store-address'), this.addressForm, {
                onSuccess: () => {
                    this.$toast.show('Адресу успішно додано!');
                    this.closeModal();
                }
            });
        },

        updateAddress(){
            router.put(route('update-address'), this.addressForm, {
                onSuccess: () => {
                    this.$toast.show('Адресу успішно оновлено!');
                    this.closeModal();
                }
            });
        },

        openDeleteModal(userAddress){
            this.addressForm = userAddress;
            this.showDeleteModal = true;
        },

        deleteAddress(){
            router.delete(route('delete-address', {id: this.addressForm.id}), {
                onSuccess: () => {
                    this.$toast.show('Адресу успішно видалено!');
                    this.closeModal();
                }
            });
        }
    },
}
</script>
