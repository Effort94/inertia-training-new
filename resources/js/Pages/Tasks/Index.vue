<template>
    <Layout>
        <div class="w-full bg-gray-100 flex items-center justify-center">
            <div class="w-full dark:bg-gray-900 shadow-lg overflow-hidden px-2">
                <div class="p-4">
                    <Datatable></Datatable>
                    <div class="flex-grow">
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
                                <th></th>
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
                                <td scope="row" class="flex items-center px-6 py-4">
                                    {{ task.title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ task.description }}
                                </td>
                                <td v-html="task.priority" class="px-6 py-4"></td>
                                <td class="px-6 py-4">
                                    <Button name="Edit" eventName="edit"></Button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!--    Pagination    -->
                    <div class="flex items-center justify-between px-4 py-3 sm:px-6 text-gray-500 dark:text-gray-400">
                        <!-- Left: Showing results info -->
                        <div class="text-sm dark:text-gray-300">
                            <p>
                                Showing
                                <span class="font-medium">{{ pagination.from }}</span>
                                to
                                <span class="font-medium">{{ pagination.to }}</span>
                                of
                                <span class="font-medium">{{ pagination.totalRecords }}</span>
                                results
                            </p>
                        </div>

                        <!-- Center: Pagination Controls -->
                        <nav class="pagination-container flex justify-center" aria-label="Pagination">
                            <ul class="flex h-10 items-center space-x-2">
                                <!-- Previous Button -->
                                <li>
                                    <a
                                        href="#"
                                        @click.prevent="changePage(pagination.currentPage - 1)"
                                        :class="[
                                          'flex items-center justify-center px-4 h-10 leading-tight border rounded-md',
                                          'text-gray-300 border-gray-300 hover:bg-gray-200 hover:text-gray-700',
                                          { 'cursor-not-allowed opacity-50': !pagination.prevPageUrl }
                                        ]"
                                        :aria-disabled="!pagination.prevPageUrl"
                                    >
                                        Previous
                                    </a>
                                </li>

                                <!-- Page Numbers -->
                                <li v-for="page in pagination.lastPage" :key="page">
                                    <a
                                        href="#"
                                        @click.prevent="changePage(page)"
                                        :class="[
                                          'flex items-center justify-center px-4 h-10 leading-tight border rounded-md',
                                          page === pagination.currentPage
                                            ? 'text-white bg-indigo-600 hover:bg-indigo-500'
                                            : 'text-gray-400 border-gray-300 hover:bg-gray-400 hover:text-gray-700 font-bold'
                                        ]"
                                    >
                                        {{ page }}
                                    </a>
                                </li>

                                <!-- Next Button -->
                                <li>
                                    <a
                                        href="#"
                                        @click.prevent="changePage(pagination.currentPage + 1)"
                                        :class="[
                                          'flex items-center justify-center px-4 h-10 leading-tight border rounded-md',
                                          'text-gray-300 border-gray-300 hover:bg-gray-200 hover:text-gray-700',
                                          { 'cursor-not-allowed opacity-50': !pagination.nextPageUrl }
                                        ]"
                                        :aria-disabled="!pagination.nextPageUrl"
                                    >
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <!-- Right: Rows per page selector -->
                        <div class="rows-per-page-selector flex items-center">
                            <label for="rowsPerPage" class="mr-2 text-sm text-gray-700 dark:text-gray-400">Rows per page:</label>
                            <select
                                id="rowsPerPage"
                                v-model="pagination.rowsPerPage"
                                @change="changePage(1)"
                                class="px-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                            >
                                <option v-for="option in pagination.rowsPerPageOptions" :key="option" :value="option">{{ option }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
            </div>
    </Layout>
</template>

<script>
import Layout from "@/Shared/Layout.vue"
import axios from "axios";
import Button from "@/Shared/Form/Button.vue";
import Datatable from "@/Shared/Datatable.vue";

export default {
    components: {
        Layout,
        Button,
        Datatable
    },

    data() {
        return {
            tasks: [],
            selectedIds: [],
            pagination: {
                page: 1,
                rowsPerPage: 15,
                rowsPerPageOptions: [15, 25, 50, 100],
            },
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
                const response = await axios.get(url, {
                    params: {
                        search: this.filters.search,
                        sortField: this.filters.sortField,
                        sortOrder: this.filters.sortOrder,
                        page: this.pagination.page,
                        limit: this.pagination.rowsPerPage
                    },
                })
                this.tasks = response.data.data;
                this.pagination = {
                    ...this.pagination,
                    prevPageUrl: response.data.previous_page,
                    nextPageUrl: response.data.next_page,
                    totalRecords: response.data.total_records,
                    lastPage: response.data.last_page,
                    currentPage: response.data.current_page,
                    from: response.data.from,
                    to: response.data.to
                }
                console.log(this.pagination);
        },
        sortBy(field) {
            this.filters.sortField = field;
            this.filters.sortOrder = this.filters.sortOrder === 'asc' ? 'desc' : 'asc';
            this.fetchTasks();
        },
        isCurrentPage(page) {
            return this.pagination.currentPage === page;
        },
        changePage(page) {
            if (page < 1 || page > this.pagination.lastPage) {
                return null;
            }

            this.pagination.page = page;

            // Fetch data
            this.fetchTasks(`/tasks/index-data?page=${page}`)
        },
    },
    computed: {
        areAllSelected() {
            return this.selectedIds.length === this.tasks.length;
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
