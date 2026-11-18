import {client} from "@/plugins/axios.js";
import {reactive} from "vue";
import {defineStore} from "pinia";

export const useGetCurrentUser = defineStore( 'getCurrentUser', () => {
    const currentUserState = reactive({
        currentUser: null,
    })

    function getCurrentUser(i) {
        return new Promise((resolve, reject) => {
            client.get('users/')
                .then((res) => {
                    console.log('Current user is accessed', res.data)
                    currentUserState.currentUser = res.data;
                    resolve();
                })
                .catch((error) => {
                    console.log('Error, currentUser is not accessed', error)
                    reject();
                })
        })
    }
    return {getCurrentUser, currentUserState}
})