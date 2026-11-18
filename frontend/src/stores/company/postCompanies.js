import {defineStore} from "pinia";
import {client} from "@/plugins/axios.js";

export const useCreateCompany = defineStore('createCompany', () => {
    function createCompany(data) {
        return new Promise((resolve, reject) => {
            client.post('companies/createCompany', data)
                .then(() => {
                    console.log('Company created successfully')
                    resolve();
                })
                .catch(() => {
                    console.log('ERROR, company is not created')
                    reject();
                })
        })
    }
    return {useCreateCompany, createCompany}
})