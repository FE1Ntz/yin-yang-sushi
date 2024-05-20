<template>
    <AdminLayout>
        <div class="p-8 flex-1 overflow-y-auto">
            <div class="flex justify-between">
                <div class="font-bold font-montserrat text-[50px]">Створити категорію</div>
            </div>
            <div class="flex flex-col w-1/2">
                <form @submit.prevent="create">
                    <InputLabel class="text-black dark:text-white text-[30px]" for="email" value="Iм'я"/>
                    <TextInput
                        id="category"
                        type="text"
                        class="mt-1 block w-full text-black dark:text-white"
                        v-model="createForm.name"
                        required
                    />
                    <div class="flex justify-between mt-4">
                        <PrimaryButton type="button"
                                       @click="goTo(route('categories.index'))"
                                       class="border p-1.5 rounded-md border-black text-black dark:text-white"
                                       :class="{ 'opacity-25': createForm.processing }"
                                       :disabled="createForm.processing">
                            Назад
                        </PrimaryButton>
                        <PrimaryButton type="submit"
                                       class="p-1.5 bg-black text-white dark:text-dark"
                                       :class="{ 'opacity-25': createForm.processing }"
                                       :disabled="createForm.processing">
                            Створити
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

    </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link} from "@inertiajs/vue3";
import {goTo} from "@/utils/utils.js";

export default {
    components: {
        PrimaryButton,
        InputLabel,
        TextInput,
        AdminLayout,
        Link
    },

    data() {
        return {
            createForm: this.createCategoryForm(),
        };
    },

    methods: {
        goTo,
        createCategoryForm() {
            return useForm({ name: '' });
        },

        create(){
            this.createForm.post(route('categories.store'));
        },
    },
}
</script>
