<template>
    <Modal v-show="isVisible" @close="close">
        <template v-slot:header>
            {{ modalHeaderText }}
        </template>
        <template v-slot:body>
            <div class="mb-6">
                <Text name="Title" v-model="form.title" :disabled="!editable"></Text>
                <div v-if="form.errors.title" v-text="form.errors.title" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-6">
                <Text name="Description" v-model="form.description" :disabled="!editable"></Text>
                <div v-if="form.errors.description" v-text="form.errors.description" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-6">
                <Select id="priority" name="Priority" v-model="form.priority" :disabled="!editable" :options="priorityOptions"></Select>
                <div v-if="form.errors.priority" v-text="form.errors.priority" class="text-red-500 text-sm mt-2"></div>
            </div>
        </template>
        <template v-slot:footer>
            <Button v-if="this.task === null"
                    name="Create"
                    @click="create"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 dark:text-gray-200"
            >
            </Button>
            <Button v-if="!editable && this.task !== null"
                    name="Edit"
                    @click="edit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 dark:text-gray-200"
            >
            </Button>
            <Button v-if="editable && this.task !== null"
                    name="Save"
                    @click="update"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 dark:text-gray-200"
            >
            </Button>
        </template>
    </Modal>
</template>
<script>

import Text from "@/Shared/Form/Text.vue";
import Select from "@/Shared/Form/Select.vue";
import Button from "@/Shared/Form/Button.vue";
import Modal from "@/Shared/Modal.vue";
import {useForm} from "@inertiajs/vue3";
export default {
    components: {
        Text,
        Select,
        Button,
        Modal,
    },
    props: {
        task: {
            type: Object,
            required: false,
        },
        isVisible: {
            type: Boolean,
            default: false,
        },
        isEditable: {
            type: Boolean,
            default: false,
        },
        priorityOptions: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                title: this.task !== null ? this.task.title : '',
                description: this.task !== null ? this.task.description : '',
                priority: this.task !== null ? this.task.priority_id : "",
            }),
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        create() {
            this.form.post('/tasks', {
                onSuccess: () => {
                    this.form.reset()
                    this.$emit('success', this.$page.props.flash.success);
                },
                onError: (errors) => {
                    this.$emit('error', this.$page.props.flash.error);
                }
            })
        },
        edit() {
            this.editable = true;
        },
        update() {
            this.form.put('/tasks/' + this.task.id, {
                onSuccess: () => {
                    this.$emit('success', this.$page.props.flash.success);
                    this.$emit('close');
                    this.$emit('refresh');
                },
                onError: () => {
                    this.error = this.$page.props.flash.errors
                }
            });
        }
    },
    computed: {
        modalHeaderText () {
            // Check if task exists
            if (this.task === null) {
                return 'Create Task';
            }

            // Task exists
            if (this.isEditable) {
                return 'Update Task';
            } else {
                return 'Show Task';
            }
        },
        editable() {
            return this.isEditable;
        }
    },
}
</script>
