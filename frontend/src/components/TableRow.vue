<script setup>
import FormTable from "@/components/tags/FormTable.vue";
</script>

<template>
    <div class="container-fluid">
        <div class="table-responsive rounded-2">
            <table class="table table-hover align-middle text-center" id="dataTable">
                <FormTable/>
                <tbody class="table_dimensions">
                <td>
                    <td>
                        <img src="@/assets/imgboy_1.jpg" class="rounded-circle me-2 m-2 img-table" alt="#">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <i
                        class="icon-link icon-link-hover link-success link-underline-success bi bi-pencil-fill"
                        data-bs-toggle="modal"
                        data-bs-target="id"
                        >
                        </i>
                    </td>
                    <td>
                        <i class="icon-link icon-link-hover link-danger link-underline-danger bi bi-trash-fill">
                        </i>
                    </td>
                </td>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>