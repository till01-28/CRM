<script setup>

defineProps({
    labelName: {
        type: String,
        required: true,
    },
    propsId: {
        type: String,
        required: true,
    },
    options: {
        type: Array,
        default: () => []
    },
    required:{
        type: Boolean,
        default: false
    },
    modelValue: {
        type: String,
        default: ''
    },

})
const emit = defineEmits(['update:modelValue']);

</script>

<template>
    <div class="mt-3">
        <label v-bind:for="propsId" class="form-label">
            {{$t(labelName)}}
            <i v-if="required" class="bi bi-asterisk asterisk"></i>
        </label>

        <select
            v-bind:id="propsId"
            class="form-select text-dark"
            v-bind:value="modelValue"
            @change="emit('update:modelValue', $event.target.value)"
        >
            <option
                v-for="option in options"
                v-bind:key="option.id"
                v-bind:value="'/api/companies/' + option.id">
                {{option.name}}
            </option>
        </select>
    </div>
</template>

<style scoped>
</style>