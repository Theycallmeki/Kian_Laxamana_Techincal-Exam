<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const employees = ref([])
const factories = ref([])
const loading = ref(true)
const searchQuery = ref('')
const error = ref(null)

// Modal State
const showModal = ref(false)
const isEditing = ref(false)
const form = ref({
  id: null,
  firstname: '',
  lastname: '',
  email: '',
  phone: '',
  factory_id: ''
})

// For debouncing search
let searchTimeout = null

// Load data initially
const fetchEmployees = async () => {
  loading.value = true
  error.value = null
  try {
    await axios.get('/sanctum/csrf-cookie')
    
    // Fetch Employees
    const response = await axios.get('/api/employees', {
      params: { search: searchQuery.value }
    })
    employees.value = response.data.data || response.data

    // Fetch Factories for the dropdown
    const factoryResponse = await axios.get('/api/factories')
    factories.value = factoryResponse.data
  } catch (err) {
    console.error(err)
    if (err.response?.status === 401) {
      error.value = 'You are not logged in! Please log into the backend at http://localhost:8000/login first.'
    } else {
      error.value = 'Failed to load data. Is the backend running?'
    }
  } finally {
    loading.value = false
  }
}

// Watch for changes in search input and debounce the API call
watch(searchQuery, (newVal) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchEmployees()
  }, 500)
})

onMounted(() => {
  fetchEmployees()
})

const openCreateModal = () => {
  isEditing.value = false
  form.value = { id: null, firstname: '', lastname: '', email: '', phone: '', factory_id: '' }
  showModal.value = true
}

const openEditModal = (emp) => {
  isEditing.value = true
  form.value = { ...emp }
  showModal.value = true
}

const saveEmployee = async () => {
  try {
    if (isEditing.value) {
      await axios.put(`/api/employees/${form.value.id}`, form.value)
    } else {
      await axios.post('/api/employees', form.value)
    }
    showModal.value = false
    fetchEmployees() // Refresh the list without page reload!
  } catch (err) {
    alert('Failed to save employee. Check your validation rules!')
    console.error(err)
  }
}

const deleteEmployee = async (id) => {
  if (!confirm('Are you sure you want to delete this employee?')) return
  
  try {
    await axios.delete(`/api/employees/${id}`)
    fetchEmployees()
  } catch (err) {
    alert('Failed to delete employee')
  }
}
</script>

<template>
  <div class="bg-white shadow rounded-lg p-6 relative">
    
    <!-- Error Alert -->
    <div v-if="error" class="bg-red-100 text-red-800 p-4 rounded mb-4">
      {{ error }}
    </div>

    <!-- Toolbar: Search & Add -->
    <div class="flex justify-between items-center mb-6">
      <input 
        v-model="searchQuery" 
        type="text" 
        placeholder="Search by first or last name..." 
        class="border border-gray-300 rounded-md shadow-sm w-1/3 p-2 text-gray-900"
      >
      <button @click="openCreateModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
        + Add Employee
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-10 text-gray-500">
      Loading employees asynchronously...
    </div>

    <!-- Empty State -->
    <div v-else-if="employees.length === 0" class="text-center py-10 text-gray-500">
      No employees found.
    </div>

    <!-- Data Table -->
    <table v-else class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Factory</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="emp in employees" :key="emp.id" class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 whitespace-nowrap">{{ emp.firstname }} {{ emp.lastname }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ emp.email }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ emp.factory ? emp.factory.factory_name : 'N/A' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
            <button @click="openEditModal(emp)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
            <button @click="deleteEmployee(emp.id)" class="text-red-600 hover:text-red-900">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Create/Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <h2 class="text-xl font-bold mb-4">{{ isEditing ? 'Edit Employee' : 'Add New Employee' }}</h2>
        
        <form @submit.prevent="saveEmployee">
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">First Name *</label>
            <input v-model="form.firstname" type="text" required class="w-full border border-gray-300 rounded p-2 text-gray-900">
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Last Name *</label>
            <input v-model="form.lastname" type="text" required class="w-full border border-gray-300 rounded p-2 text-gray-900">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Factory</label>
            <select v-model="form.factory_id" class="w-full border border-gray-300 rounded p-2 text-gray-900">
              <option value="">-- Select Factory --</option>
              <option v-for="fac in factories" :key="fac.id" :value="fac.id">
                {{ fac.factory_name }}
              </option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Email</label>
            <input v-model="form.email" type="email" class="w-full border border-gray-300 rounded p-2 text-gray-900">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Phone</label>
            <input v-model="form.phone" type="text" class="w-full border border-gray-300 rounded p-2 text-gray-900">
          </div>

          <div class="flex justify-end gap-2 mt-6">
            <button type="button" @click="showModal = false" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Cancel</button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>
