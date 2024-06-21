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
                        <th class="text-left p-4 border border-black">Ім'я</th>
                        <th class="text-left p-4 border border-black">Email</th>
                        <th class="text-left p-4 border border-black">Номер телефону</th>
                        <th class="text-left p-4 border border-black">Роль</th>
                        <th class="text-left p-4">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" class="border border-black">
                        <td class="p-4 border border-black">{{ user.id }}</td>
                        <td class="p-4 border border-black">{{ user.name }}</td>
                        <td class="p-4 border border-black">{{ user.email }}</td>
                        <td class="p-4 border border-black">{{ user.phone_number }}</td>
                        <td class="p-4 border border-black">{{ user.role }}</td>
                        <td class="p-4">
                            <div class="flex justify-around">
                                <button @click="openEditModal({...user})" class="text-blue-600 hover:underline px-1">
                                    <img :src="'/icons/pencil/pencil-white.svg'" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg w-[350px]">
                <h2 class="text-2xl mb-4">Редагувати користувача</h2>
                <form @submit.prevent="updateUser()">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Ім'я</label>
                        <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <span v-if="errors.name">{{ errors.name }}</span>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" v-model="form.email" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <span v-if="errors.email">{{ errors.email }}</span>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Номер телефону</label>
                        <input type="text" v-model="form.phone_number" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <span v-if="errors.phone_number">{{ errors.phone_number }}</span>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Роль</label>
                        <input type="text" v-model="form.role" id="name" class="mt-1 pointer-events-none opacity-40 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="mr-4 bg-gray-300 px-4 py-2 rounded-md">Скасувати</button>
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">Оновити</button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        AdminLayout,
        Link
    },

    props: {
        users: Array,
        errors: Object,
    },

    data() {
        return {
            colorTheme: 'white',
            showEditModal: false,
            form: null,
        };
    },

    methods: {
        openEditModal(user) {
            this.form = user;
            this.showEditModal = true;
        },

        closeModal() {
            this.showEditModal = false;
            this.form = null;
        },

        updateUser() {
            this.$inertia.put(route('users.update', this.form.id), this.form, {
                onSuccess: (data) => {
                    this.closeModal()},
            });
        },

    },
}
</script>

