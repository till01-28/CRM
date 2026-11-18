import {defineStore} from "pinia";
import {client} from "@/plugins/axios.js";
import {reactive} from "vue";

export const useGetUsers = defineStore('getUsers', () => {
    const userState = reactive({
        users: [],
        count: 0,
        allUsers: []
    })

    function getUsers(url = '') {
        return new Promise((resolve, reject) => {
            client.get('users/getCollectionOfUsers' + url)
                .then((res) => {
                    console.log('Users are accessed')
                    userState.users = [...res.data.member].sort((a, b) => b.id - a.id);
                    userState.count = res.data.totalItems;
                    resolve();
                })
                .catch(() => {
                    console.log('ERROR, users are not accessed')
                    reject();
                })
        })
    }

    return {getUsers, userState}
})