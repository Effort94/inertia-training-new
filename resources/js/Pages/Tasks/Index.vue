<template>
    <Layout>
        <div v-if="flashMessage" :class="flashMessage.type">
            <div class="flex">
                {{ flashMessage.message }}
            </div>
        </div>

        <div class="px-12">
            <Datatable
                ref="datatable"
                @create="createTask"
                @show="showTask"
                @edit="editTask"
                @delete="openDeleteModal"
                data-endpoint="/tasks"
                :asModalActions="true"
            ></Datatable>
        </div>

        <TaskModal v-if="showModal"
            :isVisible="showModal"
            :isEditable="isEditable"
            :task="selectedTask"
            @success="handleCreateTask"
            @close="closeModal"
            @refresh="fetchData"
        ></TaskModal>

        <Modal v-show="showDeleteModal" @close="closeModal">
            <template v-slot:header>
                Delete Task
            </template>

            <template v-slot:body>
                <div class="p-4 bg-gray-800 text-gray-200">
                    <p>Are you sure you wish to delete the task?</p>
                </div>
            </template>

            <template v-slot:footer>
                <Button
                    name="Delete"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg
                    dark:bg-red-700 dark:hover:bg-red-900"
                    @click="deleteTask(selectedTask)">
                </Button>
            </template>
        </Modal>
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
        TaskModal,
        Modal,
    },

    props: {
        flash: Object
    },

    data() {
        return {
            showModal: false,
            showDeleteModal: false,
            isEditable: false,
            selectedTask: null,
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
            this.showModal = true;
            this.isEditable = true;
        },
        openDeleteModal(taskId) {
            this.fetchTask(taskId).then(() => {
                this.showDeleteModal = true
            });
        },
        closeModal() {
            this.showModal = false;
            this.showDeleteModal = false;
            this.isEditable = false;
            this.selectedTask = null;
        },

        fetchData() {
            this.$refs.datatable.fetchTableData();
        },

        showTask(taskId)
        {
            this.fetchTask(taskId).then(() => {
                this.showModal = true;
            });
        },

        editTask(taskId) {
            this.fetchTask(taskId).then(() => {
                this.showModal = true;
                this.isEditable = true;
            });
        },

        async deleteTask() {
            if (this.selectedTask) {
                this.loading = true;
                try {
                    await this.$inertia.delete(`/tasks/${this.selectedTask}`);
                    this.fetchData();
                    this.success = this.$page.props.flash.success || '';
                } catch (error) {
                    console.error('Failed to delete task', error);
                    this.error = this.$page.props.flash.error || 'Failed to delete task. Please try again.';
                } finally {
                    this.loading = false;
                    this.showDeleteModal = false;
                }
            }
        },
        async fetchTask(taskId) {
            try {
                // Fetch the task details from the server
                const response = await axios.get(`/tasks/${taskId}`);

                // Assign the task details to the taskDetails data
                this.selectedTask = response.data.task;
            } catch (error) {
                console.error("Failed to fetch task details:", error);
            }
        }
    },
    computed: {
        flashMessage() {
            if (this.flash) {
                if (this.flash.success) {
                    return {
                        type: 'success',
                        message: this.flash.success,
                    };
                }
                if (this.flash.error) {
                    return {
                        type: 'error',
                        message: this.flash.error,
                    };
                }
            }
            return null;
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
