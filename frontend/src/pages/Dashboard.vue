<script setup>
import {useDashboardStore} from "@/stores/dashboard/useDashboardStore.js";
import {onMounted, onUnmounted, ref} from "vue";
import NavBar from "@/components/NavBar.vue";

const dashboardStore = useDashboardStore();

const currentTime = ref('');
const currentDate = ref('');
let timer = null;

function updateDateTime() {
    const now = new Date();

    currentDate.value = now.toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });

    currentTime.value = now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });
}

onMounted(() => {
    dashboardStore.fetchTotalCustom();

    updateDateTime();
    timer = setInterval(updateDateTime, 1000);
});

onUnmounted(() => {
    clearInterval(timer);
});
</script>

<template>
    <NavBar button-name="Save changes" modal-id="dashboard"/>
    <section class="page-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h1 class="welcome-title">{{$t('Welcome back, Fatkhullo!')}}</h1>
                <div class="welcome-text">{{$t('Here is what\'s happening with your CRM today.')}}</div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="date-info"><i class="bi bi-calendar3 me-2"></i>{{currentDate}}</div>
                <small class="text-secondary date-info">{{currentTime}} {{$t('Tashkent time')}}</small>
            </div>
        </div>
        <div class="row g-3 mb-4" v-if="dashboardStore.state.loading">
            <div class="col-12 text-center py-4">
                <span class="text-secondary">Loading statistics...</span>
            </div>
        </div>
        <div class="row g-3 mb-4" v-else>
            <!-- USERS -->
            <div class="col-xl-3 col-md-6">
                <div class="stat-card d-flex justify-content-start align-items-start">
                    <div class="stat-icon icon-blue"><i class="bi bi-person-fill fs-1"></i></div>
                    <div>
                        <div class="ms-4 mt-3">
                            <div class="stat-title">{{$t('Total Users')}}</div>
                            <div class="stat-number">{{dashboardStore.state.totalUsers}}</div>
                            <div>
                                <router-link class="text-decoration-none stat-change" to="/company-info">
                                <i class="bi bi-plus"></i>{{$t('Add User')}}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card d-flex justify-content-start align-items-start">
                    <div class="stat-icon icon-green"><i class="bi bi-building-fill fs-1"></i></div>
                    <div>
                        <div class="ms-4 mt-3">
                            <div class="stat-title">{{$t('Total Companies')}}</div>
                            <div class="stat-number">{{dashboardStore.state.totalCompanies}}</div>
                            <div>
                                <router-link class="text-decoration-none stat-change" to="/company-info">
                                    <i class="bi bi-plus"></i>{{$t('Add Company')}}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card d-flex justify-content-start align-items-start">
                    <div class="stat-icon icon-purple"><i class="bi bi-people-fill fs-1"></i></div>
                    <div>
                        <div class="ms-4 mt-3">
                            <div class="stat-title">{{$t('Total Customers')}}</div>
                            <div class="stat-number">{{dashboardStore.state.totalClients}}</div>
                            <div>
                                <router-link class="text-decoration-none stat-change" to="/clients-info">
                                    <i class="bi bi-plus"></i>{{$t('Add Customer')}}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card d-flex justify-content-start align-items-start">
                    <div class="stat-icon icon-orange"><i class="bi bi-clock-history fs-1"></i></div>
                    <div class="ms-4 mt-3">
                        <div class="stat-title">{{$t('Total Created Today')}}</div>
                        <div class="stat-created-today">{{$t('Users:')}}<strong>
                            {{dashboardStore.state.createdToday.totalUsersToday}}</strong>
                        </div>
                        <div class="stat-created-today">{{$t('Companies:')}}<strong>
                            {{dashboardStore.state.createdToday.totalCompaniesToday}}</strong>
                        </div>
                        <div class="stat-created-today">{{$t('Customers:')}}<strong>
                            {{dashboardStore.state.createdToday.totalClientsToday}}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* =========================
   PAGE CONTENT
========================= */

.page-content {
    padding: 30px;
}

.welcome-title {
    font-size: 18px;
    font-weight: 600;
    color: #334D6E;
    margin-bottom: 5px;
    font-family: "Poppins", sans-serif;
}

.welcome-text {
    color: #90A0B7;
    font-family: "Poppins", sans-serif;
    font-size: 14px;
}

.date-info {
    color: #90A0B7 !important;
    font-size: 13px;
    font-family: "Poppins", sans-serif;
}

/* =========================
   STAT CARDS
========================= */

.stat-card {
    background-color: white;
    border: 1px solid #e4e9f1;
    border-radius: 10px;
    padding: 20px;
    height: 100%;
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
    margin-bottom: 15px;
}

.icon-blue {
    background-color: #e5efff;
    color: #3478e5;
}

.icon-green {
    background-color: #e3f7ef;
    color: #22a66f;
}

.icon-purple {
    background-color: #eee7ff;
    color: #7146d9;
}

.icon-orange {
    background-color: #fff0dd;
    color: #e99232;
}

.stat-title {
    color: #90A0B7;
    font-size: 19px;
    margin-bottom: 4px;
    font-family: "Poppins", sans-serif;
    font-weight: 400;
}

.stat-number {
    font-size: 40px;
    font-weight: 700;
    font-family: "Poppins", sans-serif;
    margin-bottom: 7px;
    color: #707683;
}

.stat-change {
    font-size: 15px;
    color: #109CF1;
    font-family: "Poppins", sans-serif;
}

.stat-description {
    font-size: 16px;
    color: #71809a;
}

.stat-created-today{
    font-size: 16px;
    font-family: "Poppins", sans-serif;
    color: #71809a;
}
</style>