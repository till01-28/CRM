import {defineStore} from 'pinia';
import {client} from '@/plugins/axios.js';

export const useSearchUsers = defineStore('searchUsers', () => {
    function searchUsers(searchParams, endpoint){

        const params = {
            [searchParams.field]: searchParams.value
        };

        return client.get(endpoint,{
            params: params
        });
    }

    return {searchUsers};
});