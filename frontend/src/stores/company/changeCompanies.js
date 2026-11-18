import {defineStore} from "pinia";
import {client} from '@/plugins/axios.js';

export const useChangeCompany = defineStore('changeCompany', () => {
    function changeCompany(id, data) {
        return new Promise((resolve, reject) => {
            client.patch('companies/' + id, data)
                .then((res) => {
                    console.log('Company information changed successfully.');
                    resolve(res);
                })
                .catch(() => {
                    console.log('ERROR, company information is not changed')
                    reject();
                })
        })
    }
    return {changeCompany, useChangeCompany}
})