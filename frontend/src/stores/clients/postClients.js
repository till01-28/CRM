import {defineStore} from 'pinia';
import {client} from '@/plugins/axios.js';

export const useCreateClients = defineStore('createClient', () => {
    function createClient(data) {
        return new Promise((resolve, reject) => {
            client.post('clients/createClient', data)
                .then(() => {
                    console.log('Company created successfully');
                    resolve();
                })
                .catch(() => {
                    console.log('ERROR, company is not created')
                    reject();
                })
        })
    }
    return {useCreateClients, createClient}
})