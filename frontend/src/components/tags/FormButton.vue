<script setup>
defineProps({
    text: {
        type: String,
        required: true
    },
    loading: {
        type: Boolean,
        default: false,
    },
    fontWeight: {
        type: [String, Number],
        default: 600
}
})
</script>

<template>
    <button class="button-size" type="button" id="login">
        <span class="button-text" v-bind:style="{ fontWeight }">{{$t(text)}}</span>
        <span v-if="loading" class="spinner-border spinner-border-sm text-light ms-2"></span>
    </button>
</template>

<style scoped>
.button-text {
    font-family: "Poppins", sans-serif !important;
    font-size: 13px !important;
    font-weight: 600;
    line-height: 100%;
    color: #ffffff;
}
.button-size{
    width: 186px;
    height: 42px;
    background-color: #109CF1;
    cursor: pointer;
    border-radius: 4px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.button-size:hover{
    filter: brightness(95%);
}


</style>