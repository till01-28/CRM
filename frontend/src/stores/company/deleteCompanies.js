import {defineStore} from "pinia";
import {client} from "@/plugins/axios.js";

export const useDeleteCompanies = defineStore('deleteCompany', () => {
    function deleteCompany(id) {
        return new Promise((resolve, reject) => {
            client.delete('companies/'+ id)
                .then((res) => {
                    console.log('Company successfully deleted')
                    resolve(res);
                })
                .catch(() => {
                    console.log('ERROR, company is not deleted')
                    reject();
                })
        })
    }
    return {deleteCompany, useDeleteCompanies}
})
