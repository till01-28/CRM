<script setup>
defineProps({
    text:{
        type:String,
        required: true
    },
    modalId: {
        type: String,
        required: true
    }
})
</script>

<template>
    <div class="modal fade" v-bind:id="modalId" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content modal-dimensions d-flex justify-content-center align-items-center">
                <div class="d-flex align-items-center">
                    <span><i class="bi bi-check-circle modal-tick-icon"></i></span>
                    <span class="modal-text">{{$t(text)}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.modal-dimensions{
    width: 312px;
    height: 42px;
    border-radius: 4px;
    background-color: #34D47E;
    border: none;
}

.modal-text{
    font-size: 13px;
    font-family: "Poppins", serif;
    font-weight: 400;
    line-height: 100%;
    color: #ffffff;
    padding: 0 8px 0 8px;
}
.modal-tick-icon{
    color: #ffffff;
    padding: 0 8px 0 8px;
    font-size: 23px;
}
</style>