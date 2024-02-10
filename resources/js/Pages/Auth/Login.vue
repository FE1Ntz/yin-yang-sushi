<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
/*import { tw } from '@twind'*/
import { tw } from 'https://cdn.skypack.dev/twind'

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const loginForm = useForm({
    email: '',
    password: '',
    remember: false,

});

const registrationForm = useForm({
    email: '',
    password: '',
    password_confirmation: '',
});

const login = () => {
    loginForm.post(route('login'), {
        onFinish: () => loginForm.reset('password'),
    });
};
const register = () => {
    registrationForm.post(route('register'), {
        onFinish: () => registrationForm.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div id="log-in-div" :class="`${tw`${bgHeight}`} flex justify-around items-center pt-6 sm:pt-0`">
        <div
            class="w-full h-[400px] bg-opacity-85 dark:bg-opacity-85 rounded-[10px] sm:max-w-md m-2 px-6 py-4 bg-white dark:bg-black shadow-md overflow-hidden"
        >
            <form @submit.prevent="login">
                <div>
                    <InputLabel class="text-black dark:text-white" for="email" value="Email"/>

                    <TextInput
                        id="l-email"
                        type="email"
                        class="mt-1 block w-full text-white dark:text-black"
                        v-model="loginForm.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="loginForm.errors.email"/>
                </div>

                <div class="mt-4">
                    <InputLabel class="text-black dark:text-white" for="password" value="Password"/>

                    <TextInput
                        id="l-password"
                        type="password"
                        class="mt-1 block w-full text-white dark:text-black"
                        v-model="loginForm.password"
                        required
                        autocomplete="current-password"
                    />

                    <InputError class="mt-2" :message="loginForm.errors.password"/>
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="l-remember" v-model:checked="loginForm.remember"/>
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Forgot your password?
                    </Link>

                    <PrimaryButton class="ms-4 text-black dark:text-white"
                                   :class="{ 'opacity-25': loginForm.processing }" :disabled="loginForm.processing">
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </div>
        <div
            class="w-full h-[400px] bg-opacity-85 dark:bg-opacity-85 sm:max-w-md m-2 px-6 py-4 rounded-[10px] bg-white dark:bg-black shadow-md overflow-hidden"
        >
            <form @submit.prevent="register">
                <div>
                    <InputLabel class="text-black dark:text-white" for="email" value="Email"/>

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full text-black dark:text-white"
                        v-model="registrationForm.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="registrationForm.errors.email"/>
                </div>

                <div class="mt-4">
                    <InputLabel class="text-black dark:text-white" for="password" value="Password"/>

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full text-black dark:text-white"
                        v-model="registrationForm.password"
                        required
                    />

                    <InputError class="mt-2" :message="registrationForm.errors.password"/>
                </div>

                <div class="mt-4">
                    <InputLabel class="text-black dark:text-white" for="password_confirmation" value="Confirm Password"/>

                    <TextInput
                        id="confirm-password"
                        type="password"
                        class="mt-1 block w-full text-black dark:text-white"
                        v-model="registrationForm.password_confirmation"
                        required
                    />

                    <InputError class="mt-2" :message="registrationForm.errors.password"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4 text-black dark:text-white"
                                   :class="{ 'opacity-25': registrationForm.processing }"
                                   :disabled="registrationForm.processing">
                        Registration
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                windowHeight: this.windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight,
                bgHeight: 0,
            };
        },

        created() {
            this.bgHeight = `min-h-[${this.windowHeight - document.getElementById('header').offsetHeight}px]`;
            this.onWindowResize();
        },

        methods: {
            onWindowResize(){
                window.addEventListener('resize', () => {
                    this.windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
                    this.bgHeight = `min-h-[${this.windowHeight - document.getElementById('header').offsetHeight}px]`;
                });
            }
        }
    };
</script>
