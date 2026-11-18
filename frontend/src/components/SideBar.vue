<script setup>
import {useRouter} from "vue-router";
import {useToggleSidebar} from "@/stores/sidebar/toggleSidebar.js";
import {computed, onMounted} from "vue";
import {useGetCurrentUser} from "@/stores/users/getCurrentUser.js";

const host = import.meta.env.VITE_API_DOMEN;
const router = useRouter()

const userStore = useGetCurrentUser();
const currentUser = computed(() => userStore.currentUserState.currentUser)

onMounted(() => {
    userStore.getCurrentUser();
})

function logOut(){
    localStorage.removeItem('token');
    router.push('/login')
}

const toggle = useToggleSidebar();

</script>

<template>
    <aside
        class="d-flex flex-column bg-body-white vh-100 shadow sidebar position-fixed top-0 start-0"
        v-bind:class="{'expand': toggle.isExpanded}"
    >
        <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link border-bottom rounded-0 brand-height">
                        <span class="brand-expanded">Fathullo Inc</span>
                        <span class="brand-collapsed">Inc</span>
                    </a>
                </li>
            <a v-if="currentUser" href="#" class="nav-link d-flex mt-3">
                <img
                    v-if="currentUser.image"
                    class="rounded-circle img-fluid img-sidebar"
                    v-bind:src="host + currentUser.image.contentUrl"
                    alt="image">
                <div>
                    <span class="ms-3 sidebar-text">{{currentUser.fullName}} </span><br/>
                    <span class="ms-3 sidebar-text gmail_size">{{currentUser.email}} </span>
                </div>
            </a>
            <li class="nav-item">
                <router-link class="nav-link" to="/">
                    <i class="bi bi-grid p-2 sidebar-icon icon_size"></i>
                    <span class="sidebar-text">{{$t('Dashboard')}}</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/user-info">
                    <i class="bi bi-person-plus p-2 sidebar-icon icon_size"></i>
                    <span class="sidebar-text">{{$t('Users')}}</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/company-info">
                    <i class="bi bi-buildings p-2 sidebar-icon icon_size"></i>
                    <span class="sidebar-text">{{$t('Companies')}}</span>
                </router-link>
                </li>
            <li class="nav-item">
                 <router-link class="nav-link" to="/clients-info">
                    <i class="bi bi-people p-2 sidebar-icon icon_size"></i>
                    <span class="sidebar-text">{{$t('Customers')}}</span>
                 </router-link>
            </li>
            <hr/>
            <li class="nav-item">
                <router-link class="nav-link" to="/settings">
                    <i class="bi bi-gear p-2 sidebar-icon icon_size"></i>
                    <span class="sidebar-text">{{$t('Settings')}}</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link @click="logOut()" class="nav-link" to="/login">
                    <i class="bi bi-box-arrow-right p-2 sidebar-icon icon_size"></i>
                    <span class="sidebar-text">{{$t('Log out')}}</span>
                </router-link>
            </li>
        </ul>
        <div class="mt-auto">
            <button
                class="nav-link btn btn-link p-3 text-decoration-none"
                id="toggleSidebar"
                @click="toggle.toggleSidebar()"
            >
                <i class="bi bi-arrows-collapse-vertical p-2 icon_size"></i>
                <span class="sidebar-text">{{$t('Collapse')}}</span>
            </button>
        </div>
    </aside>
</template>

<style scoped>

.img-sidebar {
    width: 46px;
    height: 46px;
}
.gmail_size {
    font-size: 11px !important;
    font-weight: 500;
    color: #707683 !important;
}

.brand-expanded {
    display: inline;
    font-size: 18px;
    color: #109CF1;
    font-weight: 600 ;
    font-family: Open Sans,ui-sans-serif;
    letter-spacing: 1%;
    margin-left: 10px;
}

.brand-collapsed {
    display: none;
    font-size: 18px;
    color: #109CF1;
    font-weight: 600 ;
    font-family: Open Sans,ui-sans-serif;
    letter-spacing: 1%;
}

.sidebar:not(.expand) .brand-expanded {
    display: none;
}

.sidebar:not(.expand) .brand-collapsed {
    display: inline;
}

.icon_size{
    width: 16px !important;
    height: 16px !important;
    border-radius: 1px !important;
    color: #98A5B6;
}
.sidebar-text{
    font-size: 13px;
    color: #334D6E;
    font-weight: 500;
    height: 100%;
    letter-spacing: 1%;
}

aside .nav-link {
    text-decoration: none !important;
    color: inherit !important;
}

aside .nav-link.router-link-active {
    color: #109CF1 !important;
}

aside .nav-link.router-link-active .sidebar-icon {
    color: #109CF1 !important;
}

aside .nav-link{
    font-family: "Poppins", sans-serif;
}

.brand-height {
    height: 60px !important;
    display: flex;
    align-items: center;
}
</style>