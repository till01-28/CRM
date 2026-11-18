import {client} from '@/plugins/axios.js';
import {defineStore} from "pinia";

export const useSearchClients = defineStore('searchClients', () => {
    function searchClients(searchParams, endpoint) {
        const params = {
            [searchParams.field]: searchParams.value
        };
        return client.get(endpoint,
            {params: params});
        }
        return {searchClients, useSearchClients};
})