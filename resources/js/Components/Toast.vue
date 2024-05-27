<template>
    <div v-if="visible" class="fixed bottom-4 right-6 bg-black border-white dark:border-black border text-white dark:bg-white dark:text-black p-4 rounded shadow-lg">
        {{ message }}
    </div>
</template>

<script>
export default {
    data() {
        return {
            visible: false,
            message: ''
        };
    },
    methods: {
        showToast(message, duration = 3000) {
            this.message = message;
            this.visible = true;
            setTimeout(() => {
                this.visible = false;
            }, duration);
        }
    }
};
</script>
