<template>
    <Layout>
        <div class="w-full dark:bg-gray-900 shadow-lg overflow-hidden px-2">
            <div class="p-4">
                <Datatable
                    @create="createTask"
                    data-endpoint="/tasks/index-data"
                ></Datatable>
            </div>
        </div>

        <TaskModal :isVisible="createModalVisible" @close="closeModal"></TaskModal>
    </Layout>
</template>

<script>
import Layout from "@/Shared/Layout.vue"
import Button from "@/Shared/Form/Button.vue";
import Datatable from "@/Shared/Datatable.vue";
import TaskModal from "@/Pages/Tasks/Components/CreateModal.vue";

export default {
    components: {
        Layout,
        Button,
        Datatable,
        TaskModal,
    },

    data() {
        return {
            createModalVisible: false,
        }
    },

    methods: {
        createTask() {
            this.createModalVisible = true
        },

        closeModal() {
            this.createModalVisible = false;
        }
    }
}
</script>
<style>
.fa-arrow-up {
    color: red;
}
.fa-arrow-down {
    color: green;
}
.fa-arrow-right {
    color: orange;
}
</style>
