<template>
    <AdminLayout>
        <div class="p-8 flex-1 overflow-y-auto">
            <div class="flex justify-between">
                <div class="font-bold font-montserrat text-[50px]">Редагувати категорію</div>
            </div>
            <div class="flex flex-col w-1/2">
                <form @submit.prevent="update">
                    <InputLabel class="text-black dark:text-white text-[30px]" for="name" value="Iм'я"/>
                    <TextInput
                        id="category"
                        type="text"
                        class="mt-1 block w-full text-black dark:text-white"
                        v-model="updateForm.name"
                        required
                    />
                    <div class="flex justify-between mt-4">
                        <PrimaryButton type="button"
                                       @click="goTo(route('categories.index'))"
                                       class="border p-1.5 rounded-md border-black text-black dark:text-white"
                                       :class="{ 'opacity-25': updateForm.processing }"
                                       :disabled="updateForm.processing">
                            Назад
                        </PrimaryButton>
                        <PrimaryButton type="submit"
                                       class="p-1.5 bg-black text-white dark:text-dark"
                                       :class="{ 'opacity-25': updateForm.processing }"
                                       :disabled="updateForm.processing">
                            Редагувати
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
import {goTo} from "@/Utils/utils.js";

export default {
    props: {
        category: Object,
    },

    components: {
        PrimaryButton,
        InputLabel,
        TextInput,
        AdminLayout,
        Link
    },

    mounted() {
        console.log(this.updateCategoryForm());

    },

    data() {
        return {
            updateForm: this.updateCategoryForm(),
        };
    },

    methods: {
        goTo,
        updateCategoryForm() {
            return useForm(this.category);
        },

        update(){
            this.updateForm.put(route('categories.update', this.category.id));
        },
    },
}
</script>
