<template>
    <AdminLayout>
        <div class="p-8 flex-1 overflow-y-auto">
            <div class="flex justify-between">
                <div class="font-bold font-montserrat text-[50px]">Категорії</div>
                <div class="flex items-center">
                    <div @click="showCreateModal = true" class="bg-black text-white text-[25px] w-[35px] h-[35px] flex justify-center rounded-md items-center">
<!--                        <img :src="'/icons/pencil/pencil-' + colorTheme +'.svg'" alt="SVG Icon">-->
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
                        <th class="text-left p-4">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="category in categories" class="border border-black">
                        <td class="p-4 border border-black">{{ category.id }}</td>
                        <td class="p-4 border border-black">{{ category.name }}</td>
                        <td class="flex justify-center p-4">
                            <button @click="openEditModal(category)" class="text-blue-600 hover:underline">Редагувати</button>
                            <button @click="openDeleteModal(category)" class="text-red-600 hover:underline ml-4">Видалити</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-1/3">
                <h2 class="text-2xl mb-4">{{ showCreateModal ? 'Створити категорію' : 'Редагувати категорію' }}</h2>
                <form @submit.prevent="showCreateModal ? createCategory() : updateCategory()">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Назва</label>
                        <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
import {Link, useForm} from "@inertiajs/vue3";
import {category} from "@/models/customModels.js";

export default {
    components: {
        AdminLayout,
        Link
    },

    props: {
        categories: Array
    },

    data() {
        return {
            colorTheme: 'white',
            showCreateModal: false,
            showEditModal: false,
            showDeleteModal: false,
            form: category,
        };
    },

    methods: {
        openEditModal(category) {
            this.form = category;
            this.showEditModal = true;
        },

        openDeleteModal(category) {
            this.form.id = category.id;
            this.form.name = category.name;
            this.showDeleteModal = true;
        },

        closeModal() {
            this.showCreateModal = false;
            this.showEditModal = false;
            this.showDeleteModal = false;
            this.form = category;
        },

        createCategory() {
            this.$inertia.post(route('categories.store'), this.form, {
                onSuccess: () => this.closeModal(),
            });
        },

        updateCategory() {
            this.$inertia.put(route('categories.update', this.form.id), this.form, {
                onSuccess: () => this.closeModal(),
            });
        },

        deleteCategory() {
            this.$inertia.delete(route('categories.destroy', this.form.id), {
                onSuccess: () => this.closeModal(),
            });
        },
    },
}
</script>

