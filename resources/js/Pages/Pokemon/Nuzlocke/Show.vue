<template>
    <Layout>
        <div v-if="games.length === 0" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
            <p class="font-bold">No current games</p>
            <p>There are no games in progress. Please create a game.</p>
        </div>

        <div v-if="games.length === 0" class="flex flex-grow justify-center items-center">
            <div class="text-white">
                <button @click="showModal = true" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Create Nuzlocke Game
                </button>
            </div>
        </div>

        <div v-if="games.length > 0" class="p-6 text-white">
            <h1 class="text-xl mb-4">Your Current Games:</h1>

            <div v-for="game in games" :key="game.id" class="relative max-w-sm p-6 border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800">

                <div class="flex flex-row">
                    <div class="absolute right-4">
                        <i :class="'fas ' + game.status.icon" class="text-2xl"></i>
                    </div>

                    <div class="mb-4">
                        <h2 class="text-2xl font-semibold">{{ game.name }}</h2>
                    </div>
                </div>

                <div class="mb-4">
                    <p><strong>Players:</strong> {{ game.player_count }}</p>
                </div>

                <div class="text-center">
                    <button @click="viewGame(game.id)" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        View Game
                    </button>
                </div>
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
            showModal: false,
            success: [],
            errors: [],
        }
    },

    methods: {
        closeModal() {
            this.showModal = false;
        },

        handleSuccess() {
            this.showModal = false;
            this.success = this.$page.props.flash.success
        }
    },
}
</script>
