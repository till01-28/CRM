import {defineStore} from "pinia";
import {reactive} from "vue";
import {client} from "@/plugins/axios.js";


export const useFetchCompanies = defineStore('fetchCompanies', () => {
    const companyState = reactive({
        companies: [],
        count: 0,
        allCompanies: []
    })

    function getCompanies(url = '') {
        return new Promise((resolve, reject) => {
            client.get('companies'+ url)
                .then((res) => {
                    console.log('Companies are accessed')
                    companyState.companies = [...res.data.member].sort((a, b) => b.id - a.id);
                    companyState.count = res.data.totalItems;
                    resolve();
                })
                .catch(() => {
                    console.log('ERROR, companies are not accessed')
                    reject();
                })
        })
    }

    return {getCompanies, companyState}
})