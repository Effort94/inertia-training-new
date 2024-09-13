<template>
    <Layout>
        <div v-if="success.length > 0" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                {{ success }}
            </div>
        </div>

        <div class="w-full dark:bg-gray-900 shadow-lg overflow-hidden px-2">
            <div class="p-4">
                <Datatable
                    ref="datatable"
                    @create="createTask"
                    data-endpoint="/tasks/index-data"
                ></Datatable>
            </div>
        </div>

        <TaskModal :isVisible="createModalVisible" @success="handleCreateTask" @close="closeModal"></TaskModal>
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
            success: {},
        }
    },

    methods: {
        handleCreateTask() {
            this.fetchData();
            this.closeModal();
            this.success = this.$page.props.flash.success
        },

        createTask() {
            this.createModalVisible = true
        },

        closeModal() {
            this.createModalVisible = false;
        },

        fetchData() {
            this.$refs.datatable.fetchTableData();
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
