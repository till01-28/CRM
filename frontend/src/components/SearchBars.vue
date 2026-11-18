<script setup>
import FormSearches from "@/components/tags/FormSearches.vue";
import FormFilter from "@/components/tags/FormFilter.vue";
</script>

<template>
    <div class="container-fluid">
       <FormFilter v-bind:show-entity="true" entity-name="Kompaniyalar:"/>
        <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
            <FormSearches/>
        </div>
    </div>
</template>
<style scoped>

</style>