<script setup>
import FormButton from "@/components/tags/FormButton.vue";
import FormInput from "@/components/tags/FormInput.vue";
import {reactive,ref} from "vue";
import {useAuthorization} from "@/stores/authorization/authorization.js";
import {useRouter} from "vue-router";

let isLoading = ref(false);
let authorization = reactive({
    email:"",
    password: ""
});

const router = useRouter();
console.log(router);

function auth() {
    isLoading.value = true;
    useAuthorization().userAuth(authorization)
        .then(() => {
            router.push("/user-info");
        })
}

</script>

<template>
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-12 col-sm-8 col-md-6 col-xl-4 ">
            <form @submit.prevent="auth" class="login_font">
                <h1 class="text-center mt-3">{{$t('Log In')}}</h1>
                <FormInput v-model="authorization.email" props-id="email" label-name="Email" input-type="email"/>
                <FormInput v-model="authorization.password" props-id="password" label-name="Password" input-type="text"/>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <span class="">{{$t('Are you not signed up, yet?')}}</span> <br/>
                        <span>{{$t('Please click')}}
                            <router-link to="/register" class="text-decoration-none">{{$t('Sign Up.')}}</router-link>
                    </span>
                    </div>
                    <FormButton @click="auth()" text="Log In" v-bind:loading="isLoading"/>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.login_font{
    font-family: "Poppins", sans-serif !important;
    font-size: 14px;
    color: #444150 !important;
    font-weight: 400 !important;
}

</style>