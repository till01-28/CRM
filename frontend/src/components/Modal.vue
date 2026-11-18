<script setup>
import FormButton from "@/components/tags/FormButton.vue";
import FormInput from "@/components/tags/FormInput.vue";
import FormSelect from "@/components/tags/FormSelect.vue";
</script>

<template>
    <div class="modal fade" id="#id" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center ">
                    <h5 class="modal-title">Name</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                props-id="name"
                                label-name="To'liq Ism"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="password"
                                label-name="Password"
                                input-type="password"
                                placeholder="12345678"
                                v-bind:required="true"
                            />
                            <FormSelect
                                props-id="company"
                                label-name="Ish joyi"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="file"
                                label-name="Rasm tanlang"
                                input-type="file"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton
                        text="Qo'shish"
                        data-bs-dismiss="modal"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.modal-backdrop.show {
    opacity: 0.1;
}

.modal-content {
    background-color: #ffffff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.18);
}
</style>