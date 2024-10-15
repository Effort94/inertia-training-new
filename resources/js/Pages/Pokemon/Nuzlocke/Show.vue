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
            <h1 class="text-2xl font-semibold mb-6">Your Current Games:</h1>

            <div v-for="game in games" :key="game.id" class="relative max-w-sm p-6 border border-gray-700 rounded-lg shadow-lg dark:bg-gray-800 mb-4 transition-transform transform hover:scale-105">

                <div class="flex items-center justify-between">
                    <ul class="ml-4 mb-0 text-gray-400">
                        <li class="flex items-center mb-2">
                            <span class="text-lg font-bold text-gray-100">{{ game.name }}</span>
                        </li>
                        <li class="flex items-center mb-2">
                            <i class="fas fa-user text-gray-400"></i>
                            <span class="bg-gray-700 text-gray-200 rounded-full px-2 py-1 text-xs ml-2">{{ game.player_count }}</span>
                        </li>
                    </ul>

                    <div class="absolute top-4 right-4">
                        <i :class="'fas ' + game.status.icon" class="text-2xl text-gray-300"></i>
                    </div>
                </div>

                <div class="flex justify-end p-4 border-t border-gray-700">
                    <button @click="viewGame(game.id)" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                        View Game
                    </button>
                </div>
            </div>
        </div>

        <GameModal v-if="showModal"
                   :isVisible="showModal"
                   :nuzlockeRuleOptions="nuzlockeRuleOptions"
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
        },
        nuzlockeRuleOptions: {
            type: Array,
            required: true
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
