import { createApp } from 'vue';
import ToastComponent from '../Components/Toast.vue';

const ToastPlugin = {
    install(app) {
        const toastNode = document.createElement('div');
        document.body.appendChild(toastNode);

        const toastApp = createApp(ToastComponent);
        const toastInstance = toastApp.mount(toastNode);

        app.config.globalProperties.$toast = {
            show(message, duration) {
                toastInstance.showToast(message, duration);
            }
        };
    }
};

export default ToastPlugin;
