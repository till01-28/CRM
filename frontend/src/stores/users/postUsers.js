import {defineStore} from "pinia";
import {client} from "@/plugins/axios.js";

export const useCreateUser = defineStore("createUser", () => {
    function createUser(data) {
        return new Promise((resolve, reject) => {
            client.post('users/createUser', data)
                .then(() => {
                    console.log('User is created')
                    resolve();
                })
                .catch(() => {
                    console.log('ERROR, user is not created')
                    reject();
                })
        })
    }
    return { createUser }
})