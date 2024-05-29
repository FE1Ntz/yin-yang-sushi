<template>
    <h1 class="text-3xl font-bold">Місця в ресторані</h1>
    <div class="flex flex-wrap">
        <div class="relative border p-4 rounded-lg border-black">
            <img :src="'/img/restaurant-plan-no-bg.png'" alt="" class="min-w-[385px]">
            <div v-for="(table, index) in tables" class="absolute bg-red-700 w-[10px] text-white border border-black h-[10px] flex items-center justify-center color-red"
                 :style="{
                    left: table.x + 'px',
                    top: table.y + 'px',
                    width: table.width + 'px',
                    height: table.height + 'px',
                    borderRadius: table.isRound ? '3px' : '29px',
                    backgroundColor: table.isSelected ? '#000' : '#fff',
                    pointerEvents: table.isReserved ? 'none' : 'all',
                    opacity: table.isReserved ? '0.5' : '1',
                    color: table.isSelected ? '#fff' : '#000',
                    border: `1px solid #000`,
                }"
                @click="bookTable(index)"
            >
                {{ table.id }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tables: [
                {id: 1, x: 35, y: 16, width: 48, height: 62, isRound: true, isSelected: true, isReserved: true},
                {id: 2, x: 158, y: 16, width: 49, height: 62, isRound: true, isSelected: true, isReserved: true},
                {id: 3, x: 284, y: 19, width: 49, height: 62, isRound: true, isSelected: true, isReserved: true},
                {id: 4, x: 35, y: 146, width: 59, height: 59, isRound: false, isSelected: true, isReserved: true},
                {id: 5, x: 178, y: 146, width: 59, height: 59, isRound: false, isSelected: true, isReserved: true},
                {id: 6, x: 35, y: 267, width: 59, height: 59, isRound: false, isSelected: true, isReserved: true},
                {id: 7, x: 178, y: 267, width: 59, height: 59, isRound: false, isSelected: true, isReserved: true},
                {id: 8, x: 324, y: 267, width: 59, height: 59, isRound: false, isSelected: true, isReserved: true},
                {id: 9, x: 29, y: 385, width: 59, height: 59, isRound: false, isSelected: false, isReserved: false},
                {id: 10, x: 178, y: 385, width: 59, height: 59, isRound: false, isSelected: true, isReserved: true},
                {id: 11, x: 324, y: 385, width: 59, height: 59, isRound: false, isSelected: true, isReserved: true},
            ],
        };
    },
    methods: {
        bookTable(index) {
            this.tables[index].isSelected = !this.tables[index].isSelected;
        },

        getBgColor(table){
            if (table.isReserved) {
                return '#red'
            }

            return table.isSelected ? '#fff' : 'green'
        }
    },
};
</script>

<style scoped>
.table-number {
    font-weight: bold;
}

.table-status {
    font-size: 12px;
}

button {
    padding: 5px 10px;
    cursor: pointer;
}
</style>
