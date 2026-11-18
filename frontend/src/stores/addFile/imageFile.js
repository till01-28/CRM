import {ref} from 'vue'

export function useImageFile() {

    const file = ref()

    function selectImage(event) {
        file.value = event.target.files[0]
    }

    return {
        file,
        selectImage
    }
}