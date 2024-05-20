<template>
    <AdminLayout>
        <div class="p-8 flex-1 overflow-y-auto">
            <div class="flex justify-between">
                <div class="font-bold font-montserrat text-[50px]">Інгредієнти</div>
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
                        <th class="text-left p-4 border border-black">Чи є поширеним алергеном</th>
                        <th class="text-left p-4 border border-black">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="ingredient in ingredients" class="border border-black">
                        <td class="p-4 border border-black">
                            {{ ingredient.id }}
                        </td>
                        <td class="p-4 border border-black">
                            {{ ingredient.name }}
                        </td>
                        <td class="p-4 border border-black">
                            <img class="w-[60px]" :src="ingredient.image" alt="Ingredient image">
                        </td>
                        <td class="p-4 border border-black">
                            {{ ingredient.is_allergen ? 'Так' : 'Ні'}}
                        </td>
                        <td class="p-4">
                            <div class="flex justify-around">
                                <button @click="openEditModal({...ingredient})" class="text-blue-600 hover:underline px-1">Редагувати</button>
                                <button @click="openDeleteModal({...ingredient})" class="text-red-600 hover:underline px-1">Видалити</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-1/3">
                <h2 class="text-2xl mb-4">{{ showCreateModal ? 'Створити інгредієнт' : 'Редагувати інгредієнт' }}</h2>
                <form @submit.prevent="showCreateModal ? createCategory() : updateCategory()">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Назва
                        </label>
                        <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <label for="image" class="block text-sm font-medium text-gray-700">Зображення</label>
                        <input type="file" id="image" @change="handleFileChange" accept="image/*">
                        <label for="is_allergen" class="block text-sm font-medium text-gray-700">Чи є поширеним алергеном ?</label>
                        <input id="is_allergen" type="checkbox" v-model="form.is_allergen">
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
                <p>Ви впевнені, що хочете видалити категорію "{{ form.name }}"?</p>
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
import {ingredient} from "@/models/customModels.js";

export default {
    components: {
        AdminLayout,
        Link
    },

    props: {
        ingredients: Array
    },

    data() {
        return {
            colorTheme: 'white',
            showCreateModal: false,
            showEditModal: false,
            showDeleteModal: false,
            form: {...ingredient},
        };
    },

    mounted() {
        console.log(this.ingredients);
    },

    methods: {
        openEditModal(ingredient) {
            console.log(this.ingredients);
            this.form = ingredient;
            this.showEditModal = true;
        },

        openDeleteModal(ingredient) {
            this.form = ingredient;
            this.showDeleteModal = true;
        },

        closeModal() {
            this.showCreateModal = false;
            this.showEditModal = false;
            this.showDeleteModal = false;
            this.form = {...ingredient};
        },


        handleFileChange(event){
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = () => {
                this.form.image = reader.result;
            };

            reader.readAsDataURL(file);
        },

        createCategory() {
            this.$inertia.post(route('ingredients.store'), this.form, {
                onSuccess: () => this.closeModal(),
            });
        },

        updateCategory() {
            this.$inertia.put(route('ingredients.update', this.form.id), this.form, {
                onSuccess: () => this.closeModal(),
            });
        },

        deleteCategory() {
            this.$inertia.delete(route('ingredients.destroy', this.form.id), {
                onSuccess: () => this.closeModal(),
            });
        },
    },
}
</script>

