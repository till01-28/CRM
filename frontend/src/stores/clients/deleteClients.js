import {defineStore} from "pinia";
import {client} from "@/plugins/axios.js"

export const useDeleteClient = defineStore('deleteClient', () => {
    function deleteClient(id) {
        return new Promise((resolve, reject) => {
            client.delete('clients/' + id)
                .then((res) => {
                    console.log('Client is deleted successfully');
                    resolve(res);
                })
                .catch((err) => {
                    console.log('ERROR, client was deleted successfully');
                    reject(err);
                })
        })
    }
    return {useDeleteClient, deleteClient}
})