<script setup>
defineProps({
    editModalId:{
        type: String,
        required: true,
    }
})

</script>

<template>
    <i
        class="icon-link icon-link-hover link-success link-underline-success bi bi-pencil-fill"
        data-bs-toggle="modal"
        v-bind:data-bs-target="`#${editModalId}`"
    >
    </i>
</template>

<style scoped>

</style>