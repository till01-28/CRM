<script setup>
import SideBar from "@/components/SideBar.vue";

import {useToggleSidebar} from "@/stores/sidebar/toggleSidebar.js";

const toggle = useToggleSidebar();

</script>

<template>
    <div class="container-fluid d-flex p-0">
        <SideBar/>
        <div class="col table-content background-color" v-bind:class="{'sidebar-expanded': toggle.isExpanded}">
           <router-view/>
        </div>
    </div>
</template>

<style scoped>

</style>