<script setup>

defineProps({
    thColumns: {
        type: Array,
        default: () => []
    },
    tableRows: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <thead>
    <tr>
        <th v-for="(column, index) in thColumns" v-bind:key="index" class="font-table align-middle ps-3">
            {{$t(column)}}
        </th>
    </tr>
    </thead>
</template>

<style>

.font-table {
    color: #90A0B7 !important;
    font-family: 'Poppins',serif;
    font-weight: 500 !important;
    font-size: 13px !important;
    height: 48px !important;
}

</style>