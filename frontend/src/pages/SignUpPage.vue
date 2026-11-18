<script setup>
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
import {useRegisterStore} from "@/stores/registration/registration.js";
import {reactive, ref} from "vue";
import {useImageFile} from "@/stores/addFile/imageFile.js";
import {useAddFile} from "@/stores/mediaObject/addFile.js";
import {useRouter} from "vue-router";
import {Modal} from "bootstrap";
import FormNotificationModal from "@/components/tags/FormNotificationModal.vue";

let isLoading = ref(false);
const registerStore = useRegisterStore();
const router = useRouter();
const fileInputKey = ref(0);

const {selectImage,file} = useImageFile();

const form = reactive({
    fullName: '',
    email: '',
    plainPassword: ''
});

function showNotification() {
    const modalElement = document.getElementById('userRegistered');
    const modalInstance = new Modal(modalElement);

    modalInstance.show();

    setTimeout(() => {
        modalInstance.hide();
        router.push('/login')
    }, 3000);

}

function register() {
    isLoading.value = true;
    useAddFile().addFile(file.value)
        .then((res) => {
            form.image = res.data['@id'];
            return registerStore.register(form);
        })
        .then(() => {
            showNotification();
            console.log('Navigation succeeded');
        })
        .catch((error) => {
            console.error('Registration failed:', error);
        })
        .finally(() => {
            isLoading.value = false;

            form.fullName = '';
            form.email = '';
            form.plainPassword = '';
            file.value = null;
            fileInputKey.value++;

        })
}
</script>

<template>
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-12 col-sm-8 col-md-8 col-xl-4">
            <form @submit.prevent="register" class="border rounded sign_up_font">
                <h1 class="text-center mt-3">{{$t('Sign Up Form')}}</h1>
                    <div class="m-3">
                        <FormInput
                            v-model="form.fullName"
                            props-id="fullName"
                            label-name="Full Name"
                            input-type="text"
                            placeholder="Olimov Fathullo"
                            v-bind:required="true"
                        />
                        <FormInput
                            v-model="form.email"
                            props-id="email"
                            label-name="Email"
                            input-type="email"
                            placeholder="exmaple@gmail.com"
                            v-bind:required="true"
                        />
                        <FormInput
                            v-model="form.plainPassword"
                            props-id="password"
                            placeholder="12345678"
                            label-name="Create Password"
                            input-type="password"
                            v-bind:required="true"
                        />
                        <FormInput
                            @change="selectImage($event)"
                            props-id="addFile"
                            label-name="Upload Image"
                            input-type="file"
                            v-bind:key="fileInputKey"
                        />
                    </div>
                <div class="m-3 d-flex justify-content-between align-items-center">
                    <span
                        class="">{{$t('If you have an account.')}}
                        {{$t('Click')}}<router-link to="/login" class="text-decoration-none">{{$t('Log In')}}</router-link>
                    </span>
                    <FormButton
                        text="Sign Up"
                        type="submit"
                        v-bind:loading="isLoading"
                    />
                </div>
            </form>
        </div>
    </div>
    <FormNotificationModal modal-id="userRegistered" text="User is created successfully!"/>
</template>

<style scoped>
.sign_up_font{
    font-family: "Poppins", sans-serif !important;
    font-size: 14px;
    color: #444150 !important;
    font-weight: 400 !important;
}

</style>