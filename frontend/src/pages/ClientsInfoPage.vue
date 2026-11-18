<script setup>
import NavBar from "@/components/NavBar.vue";
import FormSearches from "@/components/tags/FormSearches.vue";
import FormFilter from "@/components/tags/FormFilter.vue";
import FormTable from "@/components/tags/FormTable.vue";
import FormEditPen from "@/components/tags/FormEditPen.vue";
import {useGetClients} from "@/stores/clients/getClients.js";
import {computed, reactive, ref} from "vue";
import {useSearchFilter} from "@/stores/searchFilter/getSearchFilter.js";
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
import FormSelect from "@/components/tags/FormSelect.vue";
import {useFetchCompanies} from "@/stores/company/getCompanies.js";
import FormDeleteTrash from "@/components/tags/FormDeleteTrash.vue";
import {useImageFile} from "@/stores/addFile/imageFile.js";
import {useAddFile} from "@/stores/mediaObject/addFile.js";
import {useCreateClients} from "@/stores/clients/postClients.js";
import FormNotificationModal from "@/components/tags/FormNotificationModal.vue";
import {Modal} from "bootstrap";
import {useChangeClients} from "@/stores/clients/changeClients.js";
import {useDeleteClient} from "@/stores/clients/deleteClients.js";
import {useSearchClients} from "@/stores/clients/useSearchClients.js";
import {format, isToday, differenceInMinutes, differenceInHours} from 'date-fns';
import {enUS, ru, uz} from 'date-fns/locale';
import {useI18n} from "vue-i18n";

const host = import.meta.env.VITE_API_DOMEN
useGetClients().getClients();
const clients = computed( () => useGetClients().clientState.clients);

useFetchCompanies().getCompanies();
const companies = computed(() => useFetchCompanies().companyState.companies);
//**********************************************************************************************************************
// CLIENT ADD BUTTON

let isLoading = ref(false);
let clientAdd = reactive({
    name: '',
    email: '',
    password: '',
    company: ''
})

function showNotification() {
    const modalElement = document.getElementById('clientAdded');
    const modalInstance = new Modal(modalElement);

    modalInstance.show();

    setTimeout(() => {
        modalInstance.hide()
    }, 30000);
}

const {selectImage, file} = useImageFile();
function create() {
    useAddFile().addFile(file.value)
        .then((res) =>{
            clientAdd.image = res.data['@id'];
            return useCreateClients().createClient(clientAdd);
        })
        .then(() => {
            useGetClients().getClients();

            clientAdd.name = '';
            clientAdd.email = '';
            clientAdd.password = '';
            clientAdd.company = '';

            showNotification();
        })
}
//**********************************************************************************************************************
// CLIENT EDIT FUNCTION

let clientEdit = reactive({
    id: '',
    name: '',
    email: '',
    password: '',
    company: '',
})

function select(client) {
    clientEdit.id = client.id;
    clientEdit.name = client.name;
    clientEdit.email = client.email;
    clientEdit.password = client.password;
    clientEdit.company = client.company;
}

function change() {
    useChangeClients().changeClient(
        clientEdit.id, {
            name: clientEdit.name,
            email: clientEdit.email,
            password: clientEdit.password,
            company: clientEdit.company
        })
        .then(() => {
            useGetClients().getClients();

            clientEdit.name = '';
            clientEdit.email = '';
            clientEdit.password = '';
            clientEdit.company = '';
        })
}
//**********************************************************************************************************************
// DELETE FUNCTION
const selectedClientId = ref(null);

function confirmDelete(id) {
    selectedClientId.value = id;
}

function remove(id){
    useDeleteClient().deleteClient(id)
        .then(() => {
            useGetClients().getClients();
        })
}

//**********************************************************************************************************************
// SEARCHBAR FUNCTIONS

const searches = [
    {
        id: 'name',
        label: 'Customer Name',
        placeholder: 'Search by customer name',
    },
    {
        id: 'email',
        label: 'Email',
        placeholder: 'Search by email',
    },
    {
        id: 'password',
        label: 'Password',
        placeholder: 'Search by password'
    },
    {
        id: 'company.name',
        label: 'Workplace',
        placeholder: 'Search by workplace',
    },
    {
        id:'createdAt',
        label: 'Creation Date',
        placeholder: 'Search by creation date',
    }
]
const {selectedSearch, visibleSearches} = useSearchFilter(searches)

const searchStore = useSearchClients();

function searchClient(searchParams) {
    const clientStore = useGetClients();

    if(!clientStore.clientState.allClients){
        clientStore.clientState.allClients = [...clientStore.clientState.clients]
    }
    if(searchParams.field === 'createdAt') {
        const query = searchParams.value.trim().toLowerCase();

        if(!clientStore.clientState.allClients || clientStore.clientState.allClients.length === 0) {
            clientStore.clientState.allClients = [...clientStore.clientState.clients];
        }

        if(!query) {
            clientStore.clientState.clients = [...clientStore.clientState.clients];
            return;
        }
        clientStore.clientState.clients = clientStore.clientState.allClients.filter((clients) => {
            if (!clients || !clients.createdAt) return false;
            try {
                const formattedDate = formatCreationDate(clients.createdAt).toLowerCase();
                return formattedDate.includes(query);
            } catch (error) {
                return false;
            }
        });
        return;
    }
    searchStore.searchClients(searchParams, 'clients/getClients')
        .then((res) => {
            const sortedClients = [...res.data.member].sort((a, b) => b.id - a.id);
            clientStore.clientState.clients = sortedClients;
            clientStore.clientState.allClients = sortedClients;
        })
        .catch(() => {
            console.log('ERROR, search is failed');
        })
}
// *********************************************************************************************************************
// TABLE MODIFICATIONS

const thClientColumns = [
    'Customers',
    'Email',
    'Password',
    'Workplace',
    "Creation Date",
    '',
    '',
]
const { t, locale } = useI18n();
const dateLocales = {en: enUS, uz, ru };

function formatCreationDate(date) {
    if (!date) {
        return t('never');
    }

    const creationDate = new Date(date);
    const now = new Date();

    const currentLocale = dateLocales[locale.value] || enUS;
    const time = format(creationDate, 'HH:mm');

    if (isToday(creationDate)) {
        const minutes = differenceInMinutes(now, creationDate);
        const hours = differenceInHours(now, creationDate);

        if (minutes < 1) {
            return t('recentlyWithTime', {time});
        }
        if (minutes < 60) {
            return `${t('minutesAgo', minutes)} ${time}`;
        }
        return `${t('hoursAgo', hours)} ${time}`;
    }
    return format(creationDate, 'dd MMM, yyyy HH:mm', {locale: currentLocale});
}
//**********************************************************************************************************************
</script>

<template>
    <NavBar button-name="Create Customer" modal-id="addClient"/>
    <div class="container-fluid">
        <div class="container-fluid">
            <FormFilter
                v-model="selectedSearch"
                v-bind:searches="searches"
                v-bind:show-entity="true"
                entity-name="Customers:"
                class="client-filter"
            />
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
                <FormSearches
                    v-bind:searches="visibleSearches"
                    @search="searchClient"
                />
            </div>
        </div>
        <div class="container-fluid">
            <div class="table-responsive rounded-2">
                <table class="table table-hover align-middle text-start" id="dtClient">
                    <FormTable v-bind:th-columns="thClientColumns"/>
                    <tbody>
                    <tr v-for="client in clients" v-bind:key="client.id" class="del-edit-iconsClient">
                        <td class="client_tbNames-font">
                            <img
                                v-if="client.image"
                                v-bind:src="host + client.image.contentUrl"
                                class="rounded-circle me-2 m-2 img-table"
                                alt="image"
                            >
                            {{client.name}}
                        </td>
                        <td class="client-tbCol-font">{{client.email}}</td>
                        <td class="client-tbCol-font">{{client.password}}</td>
                        <td class="client-tbCol-font">{{client.company.name}}</td>
                        <td class="client-tbCol-font">{{formatCreationDate(client.createdAt)}}</td>
                        <td class="penClient">
                            <FormEditPen
                                edit-modal-id="editClient"
                                @click="select(client)"
                            />
                        </td>
                        <td class="trashCanClient">
                           <FormDeleteTrash
                               edit-modal-id="editClient"
                               @click="confirmDelete(client.id)"
                               data-bs-toggle="modal"
                               data-bs-target="#confirmDeleteClient"
                           />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addClient" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title modal-font-name">{{$t('Add customer information')}}</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                v-model="clientAdd.name"
                                props-id="name"
                                label-name="Customer Name"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="clientAdd.email"
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                 v-model="clientAdd.password"
                                 props-id="password"
                                 label-name="Password"
                                 input-type="text"
                                 placeholder="12345678"
                                 v-bind:required="true"
                            />
                            <FormSelect
                                v-model="clientAdd.company"
                                v-bind:options="companies"
                                props-id="company"
                                label-name="Workplace"
                                v-bind:required="true"
                            />
                            <FormInput
                                @change="selectImage($event)"
                                props-id="file"
                                label-name="Upload Image"
                                input-type="file"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton
                        text="Create"
                        @click="create"
                        v-bind:loading="isLoading"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Close"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editClient" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center">
                    <h5 class="modal-title modal-font-name">{{$t('Edit customer information')}}</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                v-model="clientEdit.name"
                                props-id="name"
                                label-name="Customer Name"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="clientEdit.email"
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="clientEdit.password"
                                props-id="password"
                                label-name="Password"
                                input-type="text"
                                placeholder="12345678"
                                v-bind:required="true"
                            />
                            <FormSelect
                                v-model="clientEdit.company"
                                v-bind:options="companies"
                                props-id="company"
                                label-name="Workplace"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton
                        text="Save"
                        @click="change()"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Close"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteClient" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-0">
                <div class="d-flex justify-content-around align-items-center m-3">
                    <span class="client-del-name">{{$t('Do you really want to delete ?')}}</span>
                    <div>
                        <FormButton
                            type="button"
                            text="Yes"
                            class="client-del-btn client-del-red me-4 del-icon-pos"
                            @click="remove(selectedClientId)"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"
                        />

                        <FormButton
                            type="button"
                            text="No"
                            class="client-del-btn client-del-green del-icon-pos"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <FormNotificationModal
        modal-id="clientAdded"
        text="Customer is added successfully!"
        class="font-poppins_name"
    />
</template>

<style scoped>
.client-tbCol-font {
    font-family: "Poppins",serif !important;
    color: #707683;
    font-size: 13px;
    font-weight: 400;
    line-height: 100%;
}
.client_tbNames-font {
    font-family: "Poppins", serif !important;
    color: #323C47;
    font-size: 15px;
    font-weight: 500;
    line-height: 100%;
}
.client-filter{
    font-family: 'Poppins',serif !important;
    font-weight: 400;
    font-size: 12px;
    line-height: 100%;
    color: #707683;
    padding: 10px 0 10px 0;
}
.modal-font-name {
    font-family: "Poppins",serif !important;
    font-weight: 600;
    line-height: 100%;
    font-size: 13px;
}
.button-client-edit{
    width: 108px;
    height: 29px;
    line-height: 24px;
}
.client-del-btn{
    width: 94px;
    height: 30px;
    border-radius: 2px;
}
.client-del-red{
    background-color: #F7685B;
}
.client-del-green{
    background-color: #34D47E;
}
.client-del-name{
    font-family: "Poppins", sans-serif !important;
    color: #000000;
    font-size: 15px;
    font-weight: 400;
    line-height: 100%;
}

.del-edit-iconsClient{
    cursor: pointer;
    .penClient > * {
        display: none;
    }
    .trashCanClient > * {
        display: none;
    }
}
.del-edit-iconsClient:hover{
    .penClient > * {
        display: table-cell;
    }
    .trashCanClient > *{
        display: table-cell;
    }
}

#dtClient th:nth-child(1),
#dtClient td:nth-child(1) {
    width: 20%;
}

#dtClient th:nth-child(2),
#dtClient td:nth-child(2) {
    width: 21%;
}

#dtClient th:nth-child(3),
#dtClient td:nth-child(3) {
    width: 21%;
}

#dtClient th:nth-child(4),
#dtClient td:nth-child(4) {
    width: 20%;
}

#dtClient th:nth-child(5),
#dtClient td:nth-child(5){
    width: 12%;
}
#dtClient th:nth-child(6),
#dtClient td:nth-child(6) {
    width: 4%;
}
#dtClient th:nth-child(7),
#dtClient td:nth-child(7) {
    width: 3%;
}

</style>