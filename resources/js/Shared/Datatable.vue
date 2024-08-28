<template>
    <div class="flex items-center justify-between flex-column py-4 dark:bg-gray-900">
        <!--        Filters    -->
        <div class="flex space-x-4 mb-4">
            <div v-for="(options, filterType) in filters.filters" :key="filterType" class="mb-4">
                <label :for="filterType" class="font-medium text-md dark:text-gray-400">{{ filterType }}</label>
                <div class="mt-2">
                    <select :id="filterType" @change="fetchRecords" class="font-medium rounded-lg text-sm dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600">
                        <option value="">- All -</option>
                        <option v-for="(label, value) in options" :key="value" :value="value">
                            {{ label }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        
        <!--        Search     -->
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
                @keyup="fetchTasks()"
                placeholder="Search for users"
            >
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    components: {

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
                filters: {},
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
        loadFilters() {
            axios.get('/tasks/index-data/filters').then((response) => {
                this.filters.filters = response.data;

                Object.keys(this.filters).forEach(filterType => {
                    this.filters.filterType = '';
                });
            });
        },
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
    },
    mounted() {
        this.loadFilters();
    }
}
</script>
