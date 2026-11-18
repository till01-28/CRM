import {defineStore} from "pinia";
import {client} from "@/plugins/axios.js";

export const useDeleteUser = defineStore('deleteUser', () => {
    function deleteUser(id) {
        return new Promise((resolve, reject) => {
            client.delete('users/' + id)
                .then((res) => {
                    console.log('User deleted successfully')
                    resolve(res);
                })
                .catch((err) => {
                    console.log('ERROR, user is not deleted')
                    reject(err);
                })
        })
    }
    return {deleteUser}
})