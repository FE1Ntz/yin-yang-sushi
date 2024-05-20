<template>
    <AdminLayout>
        <div class="p-8 flex-1 overflow-y-auto">
            <div class="flex justify-between">
                <div class="font-bold font-montserrat text-[50px]">Категорії</div>
                <div class="flex items-center">
                    <Link :href="route('categories.create')" class="bg-black w-[35px] h-[35px] flex justify-center rounded-md items-center">
                        <img :src="'/icons/pencil/pencil-' + colorTheme +'.svg'" alt="SVG Icon">
                    </Link>
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
                            <button @click="handleEdit(category.id)" class="text-blue-600 hover:underline">Редагувати</button>
                            <button @click="handleDelete(category.id)" class="text-red-600 hover:underline ml-4">Видалити</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                    </tbody>
                </table>
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
        categories: Array
    },

    data() {
        return {
            colorTheme: 'white'
        };
    },

    methods: {
        handleEdit(id) {
            this.$inertia.get(route('categories.edit', id));
        },
        handleDelete(id) {
            this.$inertia.delete(route('categories.destroy', id));
        }
    },
}
</script>

