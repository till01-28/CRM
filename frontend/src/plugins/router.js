import{createRouter, createWebHistory} from "vue-router";
import {defineAsyncComponent} from "vue";

const ifAuthorized = (to, from) => {
    if (localStorage.getItem('token') === null) {
        return '/login';
    }
}

const ifNotAuthorized = (to, from) => {
    if (localStorage.getItem('token') !== null) {
        return '/';
    }
}

const routes = [
    {
        path: '/',
        component: () => import('@/pages/Dashboard.vue'),
        meta:{
            layout: defineAsyncComponent(() => import('@/layouts/DefaultLayout.vue'))
        },
        beforeEnter: ifAuthorized,
    },
    {
        path: '/login',
        component: () => import('@/pages/LoginPage.vue'),
        meta: {
            layout: defineAsyncComponent(() => import('@/layouts/BlankLayout.vue'))
        },
        beforeEnter: ifNotAuthorized
    },
    {
        path: '/register',
        component: () => import('@/pages/SignUpPage.vue'),
        meta: {
            layout: defineAsyncComponent(() => import('@/layouts/BlankLayout.vue'))
        },
        beforeEnter: ifNotAuthorized
    },
    {
        path: '/user-info',
        component: () => import('@/pages/UserInfoPage.vue'),
        meta:{
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        },
        beforeEnter: ifAuthorized
    },
    {
        path: '/company-info',
        component: () => import('@/pages/CompanyInfoPage.vue'),
        meta:{
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        },
        beforeEnter: ifAuthorized
    },
    {
        path: '/clients-info',
        component: () => import('@/pages/ClientsInfoPage.vue'),
        meta:{
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        },
        beforeEnter: ifAuthorized
    },
    {
        path: '/settings',
        component: () => import('@/pages/SettingsPage.vue'),
        meta: {
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        },
        beforeEnter: ifAuthorized
    }

]
export default createRouter({
    history: createWebHistory(),
    routes
})

