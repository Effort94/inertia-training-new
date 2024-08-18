<template>
    <Layout>
        <div class="relative overflow-x-auto shadow-md">
            <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                <div>
                    <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                        <span class="sr-only">Action button</span>
                        Action
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="table-search-users"
                        class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="filters.search"
                        @input="fetchTasks"
                        placeholder="Search for users"
                    >
                </div>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input
                                id="checkbox-all-search"
                                type="checkbox"
                                @change="toggleSelectAll($event)"
                                :checked="areAllSelected"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th @click="sortBy('title')" scope="col" class="px-6 py-3">
                        Title
                        <span v-if="filters.sortField === 'title'" :class="{
                          'fas fa-sort-up': filters.sortField && filters.sortOrder === 'desc',
                          'fas fa-sort-down': filters.sortField && filters.sortOrder === 'asc'
                        }"></span>
                    </th>
                    <th @click="sortBy('description')" scope="col" class="px-6 py-3">
                        Description
                        <span v-if="filters.sortField === 'description'" :class="{
                          'fas fa-sort-up': filters.sortField && filters.sortOrder === 'desc',
                          'fas fa-sort-down': filters.sortField && filters.sortOrder === 'asc'
                        }"></span>
                    </th>
                    <th @click="sortBy('priority')" scope="col" class="px-6 py-3">
                        Priority
                        <span v-if="filters.sortField === 'priority'" :class="{
                          'fas fa-sort-up': filters.sortField && filters.sortOrder === 'desc',
                          'fas fa-sort-down': filters.sortField && filters.sortOrder === 'asc'
                        }"></span>
                    </th>
                    <th @click="sortBy('status')" scope="col" class="px-6 py-3">
                        Status
                        <span v-if="filters.sortField === 'status'" :class="{
                          'fas fa-sort-up': filters.sortField && filters.sortOrder === 'desc',
                          'fas fa-sort-down': filters.sortField && filters.sortOrder === 'asc'
                        }"></span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="task in tasks" :id="task.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input
                                id="checkbox-table-search-1"
                                type="checkbox"
                                :value="task.id"
                                v-model="selectedIds"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="flex items-center px-6 py-4 whitespace-nowrap">
                        {{ task.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ task.description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.priority}}
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div>
                <button :disabled="!pagination.prev_page_url" @click="fetchTasks(pagination.prev_page_url)">Previous</button>
                <button :disabled="!pagination.next_page_url" @click="fetchTasks(pagination.next_page_url)">Next</button>
            </div>

            <div>
                <h3>Selected IDs:</h3>
                <p>{{ selectedIds }}</p>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "@/Shared/Layout.vue"
import axios from "axios";

export default {
    components: {
        Layout
    },

    data() {
        return {
            tasks: [],
            selectedIds: [],
            pagination: {},
            filters: {
                search: '',
                sortField: 'id',
                sortOrder: 'asc',
            },
        }
    },

    created() {
        this.fetchTasks();
    },

    methods: {
        toggleSelectAll(event) {
            if (event.target.checked) {
                this.selectedIds = this.tasks.map(task => task.id);
            }     else {
                this.selectedIds = [];
            }
        },
        async fetchTasks(url = '/tasks/index-data') {
            try {
                const response = await axios.get(url, {
                    params: {
                        search: this.filters.search,
                        sortField: this.filters.sortField,
                        sortOrder: this.filters.sortOrder,
                    },
                })
                this.tasks = response.data.data.data;
                this.pagination = {
                    prev_page_url: response.data.data.prev_page_url,
                    next_page_url: response.data.data.next_page_url,
                }
            } catch (error) {
                console.log(error)
            }
        },
        sortBy(field) {
            this.filters.sortField = field;
            this.filters.sortOrder = this.filters.sortOrder === 'asc' ? 'desc' : 'asc';
            this.fetchTasks();
        },
    },
    computed: {
        areAllSelected() {
            return this.selectedIds.length === this.tasks.length;
        }
    }
}
</script>
