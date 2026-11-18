<script setup>
import {reactive} from "vue";

defineProps({
    searches: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['search']);

const searchValues = reactive({});

const timeouts = {};

function handleSearch(search) {
    clearTimeout(timeouts[search.id]);

    timeouts[search.id] = setTimeout(() => {
        emit('search', {
            field: search.id,
            value: searchValues[search.id] || ''
        })
    }, 200);
}
</script>

<template>
    <div
        v-for="search in searches"
        v-bind:key="search.id"
        class="input-group shadow-sm search-box">

        <span class="input-group-text rounded-0 border-0 bg-white">
            <i class="bi bi-search searches-icon-font"></i>
        </span>

        <input
            v-model="searchValues[search.id]"
            type="text"
            class="form-control border-0 rounded-0 shadow-none searches-box-font"
            v-bind:placeholder="$t(search.placeholder)"
            @input="handleSearch(search)"
        />
    </div>
</template>

<style scoped>

.search-box {
    width: 248px;
    height: 42px;
}

.searches-box-font {
    font-family: "Poppins", sans-serif;
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    color: #90A0B7;
}

.searches-box-font::placeholder {
    color: #90A0B7;
    opacity: 1;
}

.searches-icon-font{
    color: #C2CFE0 !important;
    width: 20px;
    height: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-left: 18px;
}
</style>