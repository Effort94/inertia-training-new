<template>
    <Layout>
        <div class="w-full dark:bg-gray-900 shadow-lg overflow-hidden px-2">
            <div class="p-4">
                <Datatable
                    ref="datatable"
                    data-endpoint="/api/pokemon"
                ></Datatable>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "@/Shared/Layout.vue"
import Button from "@/Shared/Form/Button.vue";
import Datatable from "@/Shared/Datatable.vue";
import TaskModal from "@/Pages/Tasks/Components/CreateModal.vue";
import Modal from "@/Shared/Modal.vue";
import axios from "axios";

export default {
    components: {
        Layout,
        Button,
        Datatable,
    },

    methods: {
        fetchData() {
            this.$refs.datatable.fetchTableData();
        },
    },
}
</script>
