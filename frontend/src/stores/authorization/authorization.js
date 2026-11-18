import {defineStore} from "pinia";
import axios from "axios";

const host = import.meta.env.VITE_API_DOMEN;
export const useAuthorization = defineStore( 'authorization', () => {
    function userAuth(data) {
        return new Promise((resolve, reject) => {
            axios.post(host + '/api/users/auth', data)
                .then((res) => {
                    console.log('Token is Accessed')
                    localStorage.setItem('token', res.data.token)
                    resolve();
                })
                .catch(() => {
                    console.log('ERROR, token is not Accessed')
                    reject();
                })
        })
    }

    return {userAuth}
})