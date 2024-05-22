<template>
    <div class="mt-3">
        <label for="price" class="block text-sm font-medium text-gray-700">Ціна</label>
        <div class="mt-1 relative rounded-md shadow-sm">
            <input
                type="number"
                name="price"
                id="price"
                v-model="formattedPrice"
                @input="formatPrice"
                class="block w-full p-3 border border-gray-300 rounded-md focus:ring-black focus:dark:ring-white focus:border-black focus:dark:border-white sm:text-sm"
                placeholder="0.00"
                min="0"
                step="0.01"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Number,
            required: true
        }
    },

    /*created() {
      console.log(this.value);
    },*/

    data() {
        return {
            formattedPrice: this.formatNumber(this.value),
        };
    },
    methods: {
        formatNumber(number) {
            // Форматуємо число, щоб відображати його з двома знаками після коми
            return number.toFixed(2);
        },
        formatPrice(event) {
            // Отримуємо значення з події input
            let input = event.target.value;

            // Видаляємо будь-які нецифрові символи
            input = input.replace(/[^\d.]/g, '');

            // Розбиваємо на цілу частину і дробову частину
            let [integerPart, decimalPart] = input.split('.');

            // Обмежуємо довжину дробової частини до двох знаків
            decimalPart = decimalPart ? decimalPart.slice(0, 2) : '';

            // Об'єднуємо цілу та дробову частини знову
            let formattedInput = integerPart + (decimalPart ? '.' + decimalPart : '');

            // Оновлюємо відформатоване значення в моделі
            this.formattedPrice = formattedInput;

            // Емітуємо відформатоване значення для батьківського компонента
            this.$emit('setPrice', parseFloat(formattedInput));
        }
    },
};
</script>
