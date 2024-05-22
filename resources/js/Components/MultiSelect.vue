<template>
    <div class="relative">
        <div @click="toggleDropdown">
            <div class="flex items-center justify-between w-full p-3 focus:ring-black focus:dark:ring-white focus:border-black focus:dark:border-white border border-gray-300 rounded-md cursor-pointer">
                <div class="flex flex-wrap">
                    <span v-if="componentSelectedItems.length === 0">Select items...</span>
                    <span v-else>{{ componentSelectedItems.map((item) => item.name).join(', ')}}</span>
                </div>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     :class="{ 'transform rotate-180': isDropdownOpen }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        <div v-if="isDropdownOpen" id="dropdown-options" class="absolute z-10 w-full mt-1 max-h-40 overflow-y-auto bg-white border border-gray-300 rounded-md shadow-lg">
            <div v-for="(item, index) in items" :key="index" @click="toggleItem(item)"
                 class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                <input type="checkbox" :checked="arrayIncludes(item, componentSelectedItems)" class="mr-2 cursor-pointer">
                <label>{{ item.name }}</label>
            </div>
        </div>
    </div>
</template>

<script>

import _ from "lodash";
import {computed} from "vue";

export default {
    props: {
        items: {
            type: Array,
            required: true
        },
        selectedItems: {
            type: Array,
        }
    },

    data() {
        return {
            isDropdownOpen: false,
            componentSelectedItems: [...this.selectedItems],
        };
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        toggleItem(item) {
            if (this.arrayIncludes(item, this.componentSelectedItems)) {
                this.componentSelectedItems = this.componentSelectedItems.filter(el => el.id !== item.id);
            } else {
                this.componentSelectedItems.push(item);
            }

            this.$emit('setSelectedItems', [...this.componentSelectedItems]);
        },
        handleClickOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.isDropdownOpen = false;
            }
        },

        arrayIncludes(item, array){
            let isIncludes = false;

            for (let i = 0; i < array.length; i++) {
                if (_.isEqual(array[i], item)) {
                    isIncludes = true;
                    break;
                }
            }

            return isIncludes;
        },
    },
    mounted() {
        this.componentSelectedItems.forEach(item => {
            delete item.pivot;
        });

        console.log(this.items, this.componentSelectedItems);

        document.addEventListener('click', this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener('click', this.handleClickOutside);
    }
};
</script>
