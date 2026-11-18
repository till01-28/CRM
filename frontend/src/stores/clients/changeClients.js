import {client} from '@/plugins/axios.js';
import {defineStore} from "pinia";

export const useChangeClients = defineStore('changeClient',  () =>
{
    function changeClient(id, data) {
        return new Promise((resolve, reject) => {
            client.patch('clients/' + id, data)
                .then((res) => {
                    console.log('Client was changed successfully')
                    resolve(res);
                })
                .catch(() => {
                    console.log('ERROR, client information is not changed')
                    reject();
                })
        })
    }
    return {changeClient, useChangeClients}
})