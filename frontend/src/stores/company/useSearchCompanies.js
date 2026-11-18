import {client} from '@/plugins/axios.js';
import {defineStore} from 'pinia';

export const useSearchCompanies = defineStore('searchCompanies' , () => {
    function searchCompanies(searchParams, endpoint){
        const params = {
            [searchParams.field]: searchParams.value
        };
        return client.get(endpoint,
            {params: params});
    }
    return {searchCompanies, useSearchCompanies}
})