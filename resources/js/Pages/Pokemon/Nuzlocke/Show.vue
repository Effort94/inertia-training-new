<template>
    <Layout>
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
            <p class="font-bold">No current games</p>
            <p v-if="games.length === 0">There are no games in progress. Please create a game.</p>
        </div>
        <div v-if="games.length === 0" class="flex flex-grow justify-center items-center">
            <div class="text-white">
                <button @click="showModal = true" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Create Nuzlocke Game
                </button>
            </div>
        </div>

        <div v-else>
            <!-- If games exist, display them in a card layout -->
            <div class="max-w-sm p-6 border border-gray-200 rounded-lg shadow dark:bg-gray-900">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold">Game </h2>
                </div>
                <div class="mb-4">
                    <p><strong>Players:</strong> 2 </p>
                    <p><strong>Status:</strong> in progress </p>
                </div>

                <Button name="View Game">View Game</Button>
            </div>
        </div>

        <GameModal v-if="showModal"
                   :isVisible="showModal"
                   @close="closeModal"
        ></GameModal>
    </Layout>
</template>

<script>
import Layout from "@/Shared/Layout.vue"
import Button from "@/Shared/Form/Button.vue";
import Datatable from "@/Shared/Datatable.vue";
import GameModal from "@/Pages/Pokemon/Nuzlocke/Components/GameModal.vue"

export default {
    components: {
        Layout,
        Button,
        Datatable,
        GameModal
    },

    props: {
        games: {
            Type: Object,
            required: true,
        }
    },

    data() {
        return {
            showModal: false
        }
    },

    methods: {
        closeModal() {
            this.showModal = false;
        }
    }
}
</script>
