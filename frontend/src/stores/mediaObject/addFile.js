import {defineStore} from "pinia";
import {client} from "@/plugins/axios.js";

export const useAddFile = defineStore('add-file', () => {
    function addFile(data) {
        let file = new FormData()
        file.append('file',data)
        return new Promise((resolve, reject) => {
            client.post('media_objects', file)
                .then((res) => {
                    console.log('File is uploaded')
                    resolve(res)
                })
                .catch(() => {
                    console.log('ERROR, file is not uploaded')
                    reject();
                })
        })
    }
    return {addFile}
})