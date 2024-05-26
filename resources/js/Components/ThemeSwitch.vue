<template>
    <label class="switch mx-4">
        <input id="change-theme-input" :checked="isChecked" type="checkbox">
        <span @click.prevent="toggleTheme" id="change-theme-button" class="slider round"></span>
    </label>
</template>

<script>

import { toast } from "vue3-toastify";

export default {
    data(){
      return {
          isChecked: false,
          theme: 'white',
          htmlTag: document.querySelector('html'),
      }
    },

    mounted() {
        axios.get(route('get-theme')).then(res => {
            this.theme = res.data.theme;
            this.isChecked = this.theme !== 'white';
            if (this.isChecked){
                this.htmlTag.classList.add('dark');
            }
            else{
                this.htmlTag.classList.remove('dark');
            }

            this.$emit('themeColor', this.theme);
        });
    },

    methods: {
        toggleTheme(){
            this.isChecked = !this.isChecked;
            if (this.isChecked){
                this.htmlTag.classList.add('dark');
                this.theme = 'dark';
            }
            else{
                this.htmlTag.classList.remove('dark');
                this.theme = 'white';
            }

            this.$emit('themeColor', this.theme);

            axios.post(route('set-theme'), {theme: this.theme}).catch(() => {
                this.isChecked = false;
                this.theme = 'white';
                toast.error('Виникла помилка під час зміни теми');
            });
        }
    },
};
</script>
