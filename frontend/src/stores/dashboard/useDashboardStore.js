import {defineStore} from "pinia";
import {reactive} from "vue";
import {client} from "@/plugins/axios.js";

export const useDashboardStore = defineStore('dashboardStore', () => {
    const state = reactive({
        totalUsers: 0,
        totalCompanies: 0,
        totalClients: 0,
        createdToday: {
            totalUsersToday: 0,
            totalCompaniesToday: 0,
            totalClientsToday: 0,
        },
        loading: false,
    })

    function fetchTotalCustom(){
        return new Promise((resolve, reject) => {
            Promise.all([
                client.get('/users/getCollectionOfUsers?itemsPerPage=1'),
                client.get('/companies?itemsPerPage=1'),
                client.get('/clients/getClients?itemsPerPage=1'),
                client.get('/dashboard/today-stats')
            ])
                .then((responses) => {
                    const [usersRes, companiesRes, clientsRes, todayRes] = responses;

                    state.totalUsers = usersRes.data.totalItems;
                    state.totalCompanies = companiesRes.data.totalItems;
                    state.totalClients = clientsRes.data.totalItems;

                    state.createdToday = todayRes.data;

                    resolve(responses);
                })
                .catch((error) => {
                    console.error("Error loading dashboard data:", error);
                    reject(error);
                })
                .finally(() =>{
                    this.loading = false;
                });
        });
    }
    return {state, fetchTotalCustom};
});