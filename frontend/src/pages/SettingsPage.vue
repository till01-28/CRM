<script setup>
import FormInput from "@/components/tags/FormInput.vue";
import {useGetCurrentUser} from "@/stores/users/getCurrentUser.js";
import {computed, onMounted, reactive, ref, watch} from "vue";
import NavBar from "@/components/NavBar.vue";
import {useI18n} from "vue-i18n";
import {useChangeUser} from "@/stores/users/changeUsers.js";
import {useRouter} from "vue-router";

const host = import.meta.env.VITE_API_DOMEN;
const userStore = useGetCurrentUser();
const currentUser = computed(() => userStore.currentUserState.currentUser);
const i18n = useI18n();
const router = useRouter();
let isLoading = ref(false);

onMounted(() => {
    userStore.getCurrentUser();
})

let currentUserEdit = reactive({
    id:'',
    fullName: '',
    email: '',
    plainPassword: ''
});

watch(currentUser, (newUser) => {
    if (newUser) {
        currentUserEdit.id = newUser.id;
        currentUserEdit.fullName = newUser.fullName || '';
        currentUserEdit.email = newUser.email || '';
        currentUserEdit.plainPassword = newUser.plainPassword || '';
    }
}, { immediate: true });

function editCurrentUser() {
    isLoading.value = true;

    useChangeUser().changeUser(
        currentUserEdit.id, {
            fullName: currentUserEdit.fullName,
            email: currentUserEdit.email,
            plainPassword: currentUserEdit.plainPassword
        })
    .then(() => {
        localStorage.removeItem('token');
        router.push('/login');
    })
        .catch((error) => {
            console.log("Failed to update user credentials:", error)
            isLoading.value = false;
        })
}

</script>

<template>
    <NavBar
        button-name="Save changes"
        modal-id="addUser"
        @action="editCurrentUser"
        v-bind:loading="isLoading"
    />
    <!-- MAIN CONTENT CONTAINER -->
    <main class="container-fluid max-w-7xl px-3 px-md-4 pb-5">
        <!-- Header Title Banner -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2">

        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" role="tabpanel">

                <div class="row g-4">
                    <!-- LEFT COLUMN: Profile & User Credentials -->
                    <div class="col-lg-7">
                        <!-- 1. USER CREDENTIALS & PROFILE MANAGEMENT -->
                        <div class="card settings-card p-4 h-100">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-person-badge settings-icon"></i>
                                <h4
                                    class="fw-semibold mb-0 profile-title"
                                    data-i18n="profile_heading">
                                    {{$t('User Profile & Credentials')}}
                                </h4>
                            </div>
                            <p
                                class="text-secondary small mb-4 profile-description"
                                data-i18n="profile_sub">
                              {{$t('Manage your identifying information, contact credentials, and avatar.')}}
                            </p>

                            <!-- Avatar Header -->
                            <div  v-if="currentUser" class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom">
                                <div class="avatar-wrapper">
                                    <img
                                         v-if="currentUser.image"
                                         v-bind:src="host + currentUser.image.contentUrl"
                                         alt="image"
                                         class="avatar-img"
                                    >
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h5 class="mb-0 profile-name">
                                            {{currentUser.fullName}}
                                        </h5>
                                        <span
                                            class="custom-badge">
                                            {{$t('Administrator')}}
                                        </span>
                                    </div>
                                    <p class="profile-gmail mb-3">{{currentUser.email}}</p>
                                    <div class="d-flex gap-2">
                                        <button
                                            class="avatar-btn-upload rounded-2 p-1"
                                            type="button"
                                            id="changeAvatarBtn">
                                            <i class="bi bi-upload me-1"></i>
                                            <span data-i18n="upload_new">
                                                {{$t('Upload Avatar')}}
                                            </span>
                                        </button>
                                        <button
                                            class="avatar-btn-del rounded-2 p-1"
                                            type="button"
                                            id="removeAvatarBtn">
                                            <i class="bi bi-trash me-1"></i>
                                            <span data-i18n="remove">
                                                {{$t('Remove')}}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Credentials Form -->
                            <form id="credentialsForm" class="row g-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-person-gear settings-icon"></i>
                                    <h4 class="mb-0 change-credentials">{{$t('Manage Credentials')}}</h4>
                                </div>
                                    <p class="mb-0 credentials-description">
                                        {{$t('Please log in, after you change your Credentials.')}}
                                    </p>
                                <div class="col-md-6">
                                    <FormInput
                                        v-model="currentUserEdit.fullName"
                                        label-name="Full Name"
                                        input-type="text"
                                        props-id="fullName"
                                        placeholder="Olimov Fathullo"
                                        v-bind:required="true"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <FormInput
                                        v-model="currentUserEdit.email"
                                        label-name="Email"
                                        input-type="text"
                                        props-id="userEmailInput"
                                        placeholder="fathullolimov@gmail.com"
                                        v-bind:required="true"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <FormInput
                                        v-model="currentUserEdit.plainPassword"
                                        label-name="Password"
                                        input-type="text"
                                        props-id="userPasswordInput"
                                        placeholder="12345678"
                                        v-bind:required="true"
                                    />
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Theme & Localization -->
                    <div class="col-lg-5">
                        <div class="d-flex flex-column gap-4">
                            <!-- 3. LANGUAGE & i18n LOCALIZATION -->
                            <div class="card settings-card p-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="bi bi-translate settings-icon"></i>
                                    <h4
                                        class="mb-0 language-font"
                                        data-i18n="localization_heading">
                                        {{$t('Language & Region (i18n)')}}
                                    </h4>
                                </div>
                                <p
                                    class="mb-4 language-description"
                                    data-i18n="localization_sub">
                                    {{$t('Select interface language.')}}
                                </p>

                                <div class="mb-3">
                                    <label
                                        for="languageSelect"
                                        class="form-label interface-language"
                                        data-i18n="active_language">
                                        {{$t('Interface Language')}}
                                    </label>
                                    <div class="input-group">
                                        <select
                                            @change="i18n.locale.value = $event.target.value"
                                            v-bind:value="i18n.locale.value"
                                            class="form-select language-options" id="languageSelect">
                                            <option value="en">English (United States)</option>
                                            <option value="uz">O'zbekcha (Uzbek)</option>
                                            <option value="ru">Русский (Russian)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<style>

:root {
    --crm-card-border-radius: 1rem;
    --crm-transition-speed: 0.25s;
}

/* Cards & Components */

.avatar-wrapper {
    position: relative;
    width: 96px;
    height: 96px;
}

.avatar-img {
    width: 90px;
    height: 95px;
    object-fit: cover;
    border-radius: 50%;
}

.profile-title, .change-credentials, .language-font{
    font-size: 18px;
    color: #334D6E;
    font-weight: 600;
    font-family: "Poppins", sans-serif !important;
    letter-spacing: 1%;
}

.settings-icon{
    font-size: 20px;
    border-radius: 1px;
    color: #109CF1;
}

.profile-description,
.profile-gmail,
.credentials-description,
.language-description
{
    font-size: 13px;
    font-family: "Poppins", sans-serif;
    color:  #707683;
}

.profile-name {
    font-size: 18px;
    font-family: "Poppins", sans-serif;
    color: #334D6E;
    font-weight: 600;
    height: 100%;
    letter-spacing: 1%;
}

.custom-badge{
    background-color: rgba(16, 156, 241, 0.1);
    color: #109CF1;
    border: 1px solid rgba(16, 156, 241, 0.2);
    border-radius: 50px;
    padding: 4px 10px;
    font-family: "Poppins", sans-serif;
    font-size: 11px;
    font-weight: 500;
    display: inline-block;
}

.avatar-btn-del{
    font-size: 13px;
    font-family: "Poppins", sans-serif;
    color: #ff0000;
    background-color: #ffffff;
    border: #ff0000 solid 1px;
}

.avatar-btn-del:hover{
    color: #ffffff;
    background-color: #ff0000;
}

.avatar-btn-upload{
    font-size: 13px;
    font-family: "Poppins", sans-serif;
    color: #109CF1;
    background-color: #ffffff;
    border: #109CF1 solid 1px;
}

.avatar-btn-upload:hover{
    color: #ffffff;
    background-color: #109CF1;
}

.date-time-format,
.interface-language,
.language-options,
.date-time-options {
    font-size: 14px;
    font-family: "Poppins", sans-serif;
    color: #444150;
}

</style>