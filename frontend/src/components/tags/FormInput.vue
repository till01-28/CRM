<script setup>
defineProps({
    labelName:{
        type: String,
        required: true,
    },
    propsId:{
        required: true,
    },
    inputType: {
        default: "text"
    },
    placeholder:{
        type: String,
    },
    required:{
        type: Boolean,
        default: false
    },
    modelValue: {
        type: String,
        default: ''
    }
})

defineEmits(["update:modelValue"])
</script>

<template>
    <div class="mt-3">
        <label v-bind:for="propsId" class="form-label input-font">{{$t(labelName)}}
            <i v-if="required" class="bi bi-asterisk asterisk"></i></label>
        <input
            @input="$emit('update:modelValue',$event.target.value)"
            v-bind:id="propsId"
            v-bind:type="inputType"
            v-bind:placeholder="placeholder"
            v-bind:value="modelValue"
            class="form-control input-font"
        />
    </div>
</template>

<style scoped>

.input-font{
    font-family: "Poppins", sans-serif;
    color: #444150;
    font-size: 14px;
    font-weight: 400;
    line-height: 24px;
}

</style>