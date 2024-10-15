<template>
    <Modal v-show="isVisible" @close="close">
        <template v-slot:header>
            Create Game
        </template>
        <template v-slot:body>
            <div class="mb-6">
                <Text name="Name" v-model="form.name"></Text>
                <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-6">
                <Text name="Description" v-model="form.description"></Text>
                <div v-if="form.errors.description" v-text="form.errors.description" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-6">
                <Text :min="1" :max="4" name="Number of players" v-model="form.player_count" type="number"></Text>
                <div v-if="form.errors.player_count" v-text="form.errors.player_count" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-6">
                <Select id="nuzlocke-rules" name="Nuzlocke Rules" v-model="form.rules" :options="nuzlockeRuleOptions"></Select>
                <div v-if="form.errors.rules" v-text="form.errors.rules" class="text-red-500 text-sm mt-2"></div>
            </div>
        </template>
        <template v-slot:footer>
            <Button
                    name="Create"
                    @click="create"
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
        isVisible: {
            type: Boolean,
            default: false,
        },
        nuzlockeRuleOptions: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                name: '',
                player_count: '1',
                description: '',
                rules: ''
            }),
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        create() {
            this.form.post('/pokemons/nuzlocke/create', {
                onSuccess: () => {
                    this.form.reset()
                    this.$emit('handleSuccess', this.$page.props.flash.success);
                },
                onError: (errors) => {
                    this.$emit('error', this.$page.props.flash.error);
                }
            })
        },
    },
}
</script>
