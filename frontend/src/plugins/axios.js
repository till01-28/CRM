import axios from "axios";

axios.interceptors.request.use((config) => {
    config.headers.Authorization = 'Bearer ' + localStorage.getItem('token');
    config.baseURL = import.meta.env.VITE_API_DOMEN + '/api/';

    if (config.method.toLowerCase() === "patch") {
        config.headers["Content-Type"] = "application/merge-patch+json";
    } else {
        config.headers["Content-Type"] = "application/ld+json";
    }

    return config;
})

export {axios as client}