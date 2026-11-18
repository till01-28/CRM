import {defineStore} from "pinia";
import {ref} from 'vue';

export const useToggleSidebar = defineStore('toggleSidebar', () => {

    const isExpanded = ref(false);

    const toggleSidebar = () => {
        isExpanded.value = !isExpanded.value;
    }

    return {isExpanded, toggleSidebar};
});