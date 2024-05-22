<template>
    <AdminLayout>
        <div class="p-8 flex-1 overflow-y-auto">
            <div class="flex justify-between">
                <div class="font-bold font-montserrat text-[50px]">Продукти</div>
                <div class="flex items-center">
                    <div @click="showCreateModal = true" class="bg-black text-white text-[25px] w-[35px] h-[35px] flex justify-center rounded-md items-center">
                        +
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-black">
                    <thead>
                    <tr class="border border-black">
                        <th class="text-left p-4 border border-black">ID</th>
                        <th class="text-left p-4 border border-black">Назва</th>
                        <th class="text-left p-4 border border-black">Зображення</th>
                        <th class="text-left p-4 border border-black">Категорія</th>
                        <th class="text-left p-4 border border-black">Ціна</th>
                        <th class="text-left p-4 border border-black">Вага</th>
                        <th class="text-left p-4 border border-black">Знижка в %</th>
                        <th class="text-left p-4 border border-black">Ціна зі знижкою</th>
                        <th class="text-left p-4 border border-black">Інгредієгти</th>
                        <th class="text-left p-4 border border-black">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products" class="border border-black">
                        <td class="p-4 border border-black">
                            {{ product.id }}
                        </td>
                        <td class="p-4 border border-black">
                            {{ product.name }}
                        </td>
                        <td class="p-4 border border-black">
                            <img class="w-[60px]" :src="product.image" alt="Ingredient image">
                        </td>
                        <td class="p-4 border border-black">
                            {{ product.category?.name }}
                        </td>
                        <td class="p-4 border border-black">
                            {{ product.price }}
                        </td>
                        <td class="p-4 border border-black">
                            {{ product.weight }}
                        </td>
                        <td class="p-4 border border-black">
                            {{ product.discount }}
                        </td>
                        <td class="p-4 border border-black">
                            {{ product.discounted_price }}
                        </td>
                        <td class="p-4 border border-black">
                            {{ productIngredients(product.ingredients) }}
                        </td>
                        <td class="p-4">
                            <div class="flex justify-around">
                                <button @click="openEditModal({...product})" class="text-blue-600 hover:underline px-1">Редагувати</button>
                                <button @click="openDeleteModal({...product})" class="text-red-600 hover:underline px-1">Видалити</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-1/3">
                <h2 class="text-2xl mb-4">{{ showCreateModal ? 'Створити продукт' : 'Редагувати продукт' }}</h2>
                <form @submit.prevent="showCreateModal ? createCategory() : updateCategory()">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Назва
                        </label>
                        <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <label for="image" class="mt-3 block text-sm font-medium text-gray-700">
                            Зображення
                        </label>
                        <input type="file" id="image" class="outline-0" @change="handleFileChange" accept="image/*">
                        <label for="category" class="mt-3 block text-sm font-medium text-gray-700">
                            Категорія
                        </label>
                        <select v-model="form.category_id" class="block w-full p-3 border border-gray-300 rounded-md cursor-pointer">
                            <option disabled>Select an item...</option>
                            <option v-for="(item, index) in categories" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                        <PriceInput :value="showCreateModal ? 0 : form.price"
                                    @setPrice="(value) => form.price = value"
                        />
                        <label for="discount" class="mt-3 block text-sm font-medium text-gray-700">
                            Знижка в %
                        </label>
                        <input type="number" v-model="form.discount" id="discount" max="50" step="1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <label for="discounted_price" class="mt-3 block text-sm font-medium text-gray-700">
                            Вага
                        </label>
                        <input type="number" v-model="form.weight" id="discounted_price" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <label for="ingredients" class="mt-3 block text-sm font-medium text-gray-700">Інгредієнти</label>
                        <MultiSelect id="ingredients"
                                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                     :items="[...ingredients]"
                                     :selectedItems="showCreateModal ? [] : [...form.ingredients]"
                                     @setSelectedItems="(value) => form.ingredients = value"
                        />
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">{{ showCreateModal ? 'Створити' : 'Оновити' }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-1/3">
                <h2 class="text-2xl mb-4">Підтвердіть видалення</h2>
                <p>Ви впевнені, що хочете видалити продукт "{{ form.name }}"?</p>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                    <button type="button" @click="deleteCategory" class="bg-red-600 text-white px-4 py-2 rounded-md">Видалити</button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import {product} from "@/models/customModels.js";
import MultiSelect from "@/Components/MultiSelect.vue";
import PriceInput from "@/Components/PriceInput.vue";

export default {
    components: {
        PriceInput,
        AdminLayout,
        Link,
        MultiSelect
    },

    props: {
        products: Array,
        ingredients: Array,
        categories: Array,
    },

    data() {
        return {
            colorTheme: 'white',
            showCreateModal: false,
            showEditModal: false,
            showDeleteModal: false,
            form: {...product},
        };
    },

    mounted() {
        console.log(this.products);
    },

    methods: {
        openEditModal(product) {
            this.form = product;
            this.showEditModal = true;
        },

        openDeleteModal(product) {
            this.form = product;
            this.showDeleteModal = true;
        },

        closeModal() {
            this.showCreateModal = false;
            this.showEditModal = false;
            this.showDeleteModal = false;
            console.log(this.form);
            this.form = {...product};
        },

        handleFileChange(event){
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = () => {
                this.form.image = reader.result;
            };

            reader.readAsDataURL(file);
        },

        productIngredients(ingredients) {
            if (ingredients.length > 0) {
                return ingredients.map((ingredient) => ingredient.name).join(', ');
            }

            return '-';
        },

        createCategory() {
            this.$inertia.post(route('products.store'), this.form, {
                onSuccess: () => this.closeModal(),
            });
        },

        updateCategory() {
            this.$inertia.put(route('products.update', this.form.id), this.form, {
                onSuccess: () => this.closeModal(),
            });
        },

        deleteCategory() {
            this.$inertia.delete(route('products.destroy', this.form.id), {
                onSuccess: () => this.closeModal(),
            });
        },
    },
}
</script>

