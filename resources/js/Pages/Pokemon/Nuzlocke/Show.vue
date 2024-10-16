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
        <div v-if="games.length > 0" class="p-6 dark:text-white">
            <h1 class="text-3xl font-bold mb-8">Your Current Games:</h1>

            <div class="flex flex-col md:flex-row md:flex-wrap gap-12">
                <div v-for="game in games" :key="game.id" class="flex-col my-6 dark:bg-slate-800 border dark:border-slate-700 rounded-lg w-96 transition-transform transform hover:scale-105">
                    <div class="border-b dark:border-slate-700 pt-3 px-3 pb-2">
                      <span class="text-xl font-medium dark:text-slate-200">
                        {{ game.name }}
                      </span>
                    </div>

                    <div class="text-sm dark:text-slate-400 mt-4">
                        <div class="flex flex-col dark:text-slate-300 gap-y-2 px-8 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-list text-blue-500 w-8"></i>
                                <p class="text-right font-semibold">{{ game.rule.name }}</p>
                            </div>

                            <div class="flex items-center">
                                <i class="fas fa-users text-blue-500 w-8"></i>
                                <p class="text-right font-semibold">{{ game.player_count }}</p>
                            </div>

                            <div class="flex items-center">
                                <i class="fas fa-rotate-right text-blue-500 w-8"></i>
                                <p class="text-right font-semibold">{{ game.attempts }}</p>
                            </div>

                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-blue-500 w-8"></i>
                                <p class="text-right font-semibold">{{ game.start_date }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 dark:border-slate-700 p-3 text-right">
                        <button @click="viewGame(game.id)"
                                class="text-sm px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            View Game
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <GameModal v-if="showModal"
                   :isVisible="showModal"
                   :nuzlockeRuleOptions="nuzlockeRuleOptions"
                   @create="handleSuccess"
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
