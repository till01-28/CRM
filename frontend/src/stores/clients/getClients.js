import {defineStore} from "pinia";
import {reactive} from "vue";
import {client} from "@/plugins/axios.js";

export const useGetClients = defineStore('getClients', () => {
    const clientState = reactive({
        clients: [],
        count: 0,
        allClients: []
        })

    function getClients(url = '') {
        return new Promise((resolve, reject) => {
            client.get('clients/getClients'+ url)
                .then((res) => {
                    console.log('Clients are accessed')
                    clientState.clients = [...res.data.member].sort((a, b) => b.id - a.id);
                    clientState.count = res.data.totalItems;
                    resolve();
                })
                .catch(() => {
                    console.log('Clients are not accessed')
                    reject();
                })
        })
    }

    return {getClients, clientState}
})