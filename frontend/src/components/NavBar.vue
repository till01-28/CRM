<script setup>
import {useToggleSidebar} from "@/stores/sidebar/toggleSidebar.js";
import FormButton from "@/components/tags/FormButton.vue";
const toggle = useToggleSidebar();

defineProps({
    buttonName: {
        type: String,
        required: true,
    },

    modalId: {
        type: String,
        required: true,
    },

    loading: {
        type: Boolean,
        default: false,
    }
})

const emit = defineEmits(['action']);
</script>

<template>
    <nav class="navbar navbar-expand navbar-dark bg-white navbar_dimensions me-4 ms-4 ">
            <button
                class="btn btn-outline-secondary d-md-none ms-3"
                @click="toggle.toggleSidebar()"
            >
                <i class="bi bi-list"></i>
            </button>

            <FormButton
                v-if="modalId!== 'dashboard'"
                class="ms-auto me-3"
                type="button"
                data-bs-toggle="modal"
                v-bind:data-bs-target="`#${modalId}`"
                v-bind:text="`${$t(buttonName)}`"
                v-bind:loading="loading"
                @click="emit('action')"
            />
    </nav>
</template>

<style scoped>
.navbar_dimensions {
    height: 61px;
}
</style>