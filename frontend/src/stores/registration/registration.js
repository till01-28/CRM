import {defineStore} from 'pinia';
import axios from 'axios';

const host = import.meta.env.VITE_API_DOMEN;
export const useRegisterStore = defineStore('register', {
    state: () => ({
        user: null
    }),
    actions: {
        async register(form) {
            console.log('Creating user:', form)

            const response = await axios.post(host + '/api/users/createUser',{
                fullName: form.fullName,
                email: form.email,
                plainPassword: form.plainPassword,
                image: form.image
            })
            console.log('User created:', response.data);

            return response.data;
        }
    }
})