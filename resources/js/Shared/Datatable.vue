<template>
    <div class="flex flex-col py-4 dark:bg-gray-900">
        <!-- Filters and Search -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
            <!-- Filters -->
            <div class="flex space-x-4">
                <div v-for="(options, filterType) in filters.filters" :key="filterType">
                    <label :for="filterType" class="font-medium text-md dark:text-gray-400">{{ filterType }}</label>
                    <div>
                        <select @change="filterDatatable($event, filterType)"
                                class="font-medium rounded-lg text-sm dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600">
                            <option value="">- All -</option>
                            <option v-for="(label, value) in options" :key="value" :value="value">
                                {{ label }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="relative flex-grow max-w-sm">
                <label for="table-search" class="sr-only">Search</label>
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    id="table-search-users"
                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    v-model="filters.search"
                    @keyup="fetchTableData()"
                    placeholder="Search for users"
                >
            </div>

            <!-- Create Button -->
            <div class="text-right">
                <Button name="create" @click="create">Create</Button>
            </div>
        </div>

        <!--   Table     -->
        <div class="flex-grow">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                @change="toggleSelectAll($event)"
                                :checked="areAllSelected"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th v-for="header in tableHeaders" :key="header" @click="sortBy(header)" class="px-6 py-3">
                        {{ header }}
                        <span v-if="sort.sortField === header" :class="{
                          'fas fa-sort-up': sort.sortField && sort.sortOrder === 'desc',
                          'fas fa-sort-down': sort.sortField && sort.sortOrder === 'asc'
                        }"></span>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- Display message when there are no items -->
                <tr v-if="!tableData.length">
                    <td colspan="100%" class="text-center text-xl h-24 border-t-2 border-b-2">
                        <div class="flex items-center justify-center w-full h-full border-1">
                            There are no items
                        </div>
                    </td>
                </tr>

                <!-- Loop through table data -->
                <tr v-for="data in tableData" :key="data.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                :value="data.id"
                                v-model="selectedIds"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                        </div>
                    </td>

                    <!-- Dynamic Data Columns -->
                    <td
                        v-for="value in Object.keys(data).filter(key => key !== 'id')"
                        :key="`${data.id}-${value}`"
                        class="px-6 py-4"
                        v-html="data[value]">
                    </td>

                    <!-- Action Menu Column -->
                    <td class="px-6 py-4 text-right">
                        <div class="relative inline-block text-left">
                            <!-- Action Menu Toggle Button -->
                            <button
                                @click="showActionMenu(data.id)"
                                type="button"
                                class="inline-flex items-center p-2 text-sm font-medium text-gray-400 bg-gray-800 rounded-md shadow-sm hover:bg-gray-700 dark:text-gray-300 dark:bg-gray-900 dark:hover:bg-gray-700"
                                @click.stop
                            >
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h.01M12 12h.01M18 12h.01" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div v-show="openActionMenu" v-if="activeActionMenuId === data.id" class="absolute right-full ml-2 top-0 w-56 z-50 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-900 dark:ring-gray-700 transition transform ease-out duration-300 origin-left">
                                <div class="p-1">
                                    <a @click="action('view', data.id)" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 cursor-pointer dark:hover:bg-gray-700">
                                        <i class="far far fa-eye mr-2"></i> View
                                    </a>
                                    <hr class="my-1 border-gray-600 dark:border-gray-700">
                                    <a @click="action('edit', data.id)" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 cursor-pointer dark:hover:bg-gray-700">
                                        <i class="fa far fa-edit mr-2"></i> Edit
                                    </a>
                                    <hr class="my-1 border-gray-600 dark:border-gray-700">
                                    <a @click="action('delete', data.id)" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 cursor-pointer dark:hover:bg-gray-700">
                                        <i class="fa far fa-trash mr-2"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <!--    Pagination    -->
            <div class="flex items-center justify-between px-4 py-3 sm:px-6 text-gray-500 dark:text-gray-400">
                <!-- Left: Showing results info -->
                <div class="text-sm dark:text-gray-300">
                    <p>
                        Showing
                        <span class="font-medium">{{ fromRecords }}</span>
                        to
                        <span class="font-medium">{{ toRecords }}</span>
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
                    <label for="rowsPerPage" class="mr-2 text-sm text-gray-700 dark:text-gray-400">Rows per
                        page:</label>
                    <select
                        id="rowsPerPage"
                        v-model="pagination.rowsPerPage"
                        @change="changePage(1)"
                        class="px-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                    >
                        <option v-for="option in pagination.rowsPerPageOptions" :key="option" :value="option">{{
                                option
                            }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Button from "@/Shared/Form/Button.vue";

export default {
    components: {
        Button,
    },

    props: {
        dataEndpoint: {
            type: String,
            default: null,
        }
    },

    data() {
        return {
            tableData: [],
            tableHeaders: [],
            selectedIds: [],
            pagination: {
                page: 1,
                rowsPerPage: 15,
                rowsPerPageOptions: [15, 25, 50, 100],
            },
            filters: {
                filters: {},
            },
            appliedFilters: {},
            sort: {
                sortField: 'id',
                sortOrder: 'asc',
            },
            search: '',
            url: this.dataEndpoint + '/index-data',
            activeActionMenuId: null,
            asModalActions: false,
            openActionMenu: false
        }
    },

    created() {
        this.fetchTableData();
    },

    methods: {
        loadFilters() {
            axios.get(this.url + '/filters').then((response) => {
                this.filters.filters = response.data;
            });
        },
        toggleSelectAll(event) {
            if (event.target.checked) {
                this.selectedIds = this.tableData.map(data => data.id);
            } else {
                this.selectedIds = [];
            }
        },
        async fetchTableData() {
            const response = await axios.get(this.url, {
                params: {
                    search: this.search,
                    filters: this.appliedFilters,
                    sortField: this.sort.sortField,
                    sortOrder: this.sort.sortOrder,
                    page: this.pagination.page,
                    limit: this.pagination.rowsPerPage
                },
            })
            this.tableData = response.data.data;
            this.tableHeaders = response.data.headers;

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
        },
        async handleAction(action, id) {
            this.closeActionMenu()

            switch (action) {
                case 'view':
                    this.$emit('show', id);
                    break;
                case 'edit':
                    this.$emit('edit', id);
                    break;
                case 'delete':
                    this.$emit('delete', id);
                    break;
            }
        },
        sortBy(field) {
            this.sort.sortField = field;
            this.sort.sortOrder = this.sort.sortOrder === 'asc' ? 'desc' : 'asc';
            this.fetchTableData();
        },
        filterDatatable(event, filterType) {
            if (event.target.value !== null) {
                this.appliedFilters = {[filterType]: event.target.value}
            }
            this.fetchTableData();
        },
        changePage(page) {
            if (page < 1 || page > this.pagination.lastPage) {
                return null;
            }

            this.pagination.page = page;

            // Fetch data
            this.fetchTableData(`${this.url}?page=${page}`)
        },
        create() {
            this.$emit('create');
        },
        showActionMenu(id) {
            this.openActionMenu = true;
            this.activeActionMenuId = this.activeActionMenuId === id ? null : id;
            if (this.activeActionMenuId) {
                document.addEventListener('click', this.handleOutsideClick);
            } else {
                document.removeEventListener('click', this.handleOutsideClick);
            }
        },
        closeActionMenu() {
            this.openActionMenu = false;
        },
        action(action, id) {
            this.activeActionMenuId = null;

            if (this.asModalActions) {
                this.$emit(action)
            } else {
                this.handleAction(action, id);
            }
        },
        handleOutsideClick(event) {
            const dropdown = this.$el.querySelector(
                '.absolute.right-full'
            );
            if (dropdown && !dropdown.contains(event.target)) {
                this.activeActionMenuId = null;
                document.removeEventListener('click', this.handleOutsideClick);
            }
        },
    },
    computed: {
        areAllSelected() {
            return this.selectedIds.length === this.tableData.length;
        },
        fromRecords() {
            return this.pagination.from !== null ? this.pagination.from : 0;
        },
        toRecords() {
            return this.pagination.to !== null ? this.pagination.to : 0;
        }
    },
    mounted() {
        this.fetchTableData();
        this.loadFilters();
    }
}
</script>
