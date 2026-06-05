<template>
    <div>
        <div class="flex justify-between items-center mb-4">
            <button @click="openCreateModal" class="bg-blue-500 text-white px-4 py-2 rounded">Add Employee</button>
            <input 
                v-model="search" 
                @input="onSearchInput" 
                type="text" 
                placeholder="Search employees..." 
                class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
        </div>

        <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ error }}</span>
        </div>

        <div v-if="loading" class="flex justify-center py-8">
            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <div v-else-if="employees.length === 0" class="text-center py-8 text-gray-500">
            No employees found.
        </div>

        <div v-else>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b py-2 px-4">First Name</th>
                        <th class="border-b py-2 px-4">Last Name</th>
                        <th class="border-b py-2 px-4">Factory</th>
                        <th class="border-b py-2 px-4">Email</th>
                        <th class="border-b py-2 px-4">Phone</th>
                        <th class="border-b py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees" :key="employee.id" :class="{'opacity-50': isActionLoading(employee.id)}">
                        <td class="border-b py-2 px-4">{{ employee.firstname }}</td>
                        <td class="border-b py-2 px-4">{{ employee.lastname }}</td>
                        <td class="border-b py-2 px-4">{{ employee.factory ? employee.factory.factory_name : '' }}</td>
                        <td class="border-b py-2 px-4">{{ employee.email }}</td>
                        <td class="border-b py-2 px-4">{{ employee.phone }}</td>
                        <td class="border-b py-2 px-4">
                            <button @click="openEditModal(employee)" class="text-blue-500" :disabled="isActionLoading(employee.id)">Edit</button>
                            <button @click="deleteEmployee(employee.id)" class="text-red-500 ml-2" :disabled="isActionLoading(employee.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="mt-4 flex justify-between items-center" v-if="pagination.total > 0">
                <span>Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results</span>
                <div class="flex space-x-2">
                    <button 
                        @click="fetchEmployees(pagination.current_page - 1)" 
                        :disabled="!pagination.prev_page_url"
                        class="px-3 py-1 border rounded disabled:opacity-50">
                        Previous
                    </button>
                    <button 
                        @click="fetchEmployees(pagination.current_page + 1)" 
                        :disabled="!pagination.next_page_url"
                        class="px-3 py-1 border rounded disabled:opacity-50">
                        Next
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
            <div class="bg-white p-8 rounded shadow-md w-1/2">
                <h3 class="text-lg font-bold mb-4">{{ modalMode === 'create' ? 'Add Employee' : 'Edit Employee' }}</h3>
                <form @submit.prevent="saveEmployee">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">First Name *</label>
                        <input v-model="form.firstname" type="text" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Last Name *</label>
                        <input v-model="form.lastname" type="text" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Factory *</label>
                        <select v-model="form.factory_id" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                            <option value="" disabled>Select Factory</option>
                            <option v-for="factory in factories" :key="factory.id" :value="factory.id">{{ factory.factory_name }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input v-model="form.email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                        <input v-model="form.phone" type="text" class="shadow appearance-none border rounded w-full py-2 px-3">
                    </div>
                    
                    <div class="flex justify-end mt-4">
                        <button type="button" @click="closeModal" class="mr-2 px-4 py-2 bg-gray-300 rounded text-black">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 rounded text-white" :disabled="modalLoading">
                            {{ modalLoading ? 'Saving...' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            employees: [],
            factories: [],
            loading: true,
            error: null,
            search: '',
            searchTimeout: null,
            pagination: {
                current_page: 1,
                last_page: 1,
                total: 0,
                from: 0,
                to: 0,
                prev_page_url: null,
                next_page_url: null
            },
            
            showModal: false,
            modalMode: 'create', // create or edit
            modalLoading: false,
            form: {
                id: null,
                firstname: '',
                lastname: '',
                factory_id: '',
                email: '',
                phone: ''
            },
            
            actionLoadingIds: [] // Track which rows are currently being edited/deleted
        };
    },
    mounted() {
        this.fetchEmployees();
        this.fetchFactories();
    },
    methods: {
        async fetchEmployees(page = 1) {
            this.loading = true;
            this.error = null;
            try {
                // To handle overlapping requests we could use an abort controller, 
                // but setting loading = true and overwriting handles standard UI needs well.
                const response = await axios.get('/api/employees', {
                    params: { page, search: this.search }
                });
                
                this.employees = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    total: response.data.total,
                    from: response.data.from,
                    to: response.data.to,
                    prev_page_url: response.data.prev_page_url,
                    next_page_url: response.data.next_page_url
                };
            } catch (err) {
                this.error = "Failed to load employees. " + (err.response?.data?.message || err.message);
            } finally {
                this.loading = false;
            }
        },
        async fetchFactories() {
            try {
                const response = await axios.get('/api/factories');
                this.factories = response.data;
            } catch (err) {
                console.error("Failed to load factories", err);
            }
        },
        onSearchInput() {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            // Debounce for 300ms
            this.searchTimeout = setTimeout(() => {
                this.fetchEmployees(1);
            }, 300);
        },
        openCreateModal() {
            this.modalMode = 'create';
            this.form = { id: null, firstname: '', lastname: '', factory_id: '', email: '', phone: '' };
            this.showModal = true;
        },
        openEditModal(employee) {
            this.modalMode = 'edit';
            this.form = { ...employee };
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        async saveEmployee() {
            this.modalLoading = true;
            this.error = null;
            try {
                if (this.modalMode === 'create') {
                    await axios.post('/api/employees', this.form);
                } else {
                    await axios.put(`/api/employees/${this.form.id}`, this.form);
                }
                this.closeModal();
                this.fetchEmployees(this.pagination.current_page);
            } catch (err) {
                alert("Failed to save employee. " + (err.response?.data?.message || err.message));
            } finally {
                this.modalLoading = false;
            }
        },
        async deleteEmployee(id) {
            if (!confirm('Are you sure you want to delete this employee?')) return;
            
            this.actionLoadingIds.push(id);
            try {
                await axios.delete(`/api/employees/${id}`);
                this.fetchEmployees(this.pagination.current_page);
            } catch (err) {
                alert("Failed to delete employee. " + (err.response?.data?.message || err.message));
            } finally {
                this.actionLoadingIds = this.actionLoadingIds.filter(lid => lid !== id);
            }
        },
        isActionLoading(id) {
            return this.actionLoadingIds.includes(id);
        }
    }
};
</script>
