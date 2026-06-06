<script setup>
import { ref, onMounted, watch } from 'vue'
import api from '../services/api'
import { useLoader } from '../composables/useLoader'

import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import Message from 'primevue/message'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'
import EmployeeFormModal from './EmployeeFormModal.vue'

const employees = ref([])
const factories = ref([])
const { isLoading, startLoading, stopLoading } = useLoader()
const searchQuery = ref('')
const error = ref(null)

const showModal = ref(false)
const isEditing = ref(false)
const isSaving = ref(false)
const deletingId = ref(null)
const form = ref({
  id: null,
  firstname: '',
  lastname: '',
  email: '',
  phone: '',
  factory_id: ''
})

let searchTimeout = null

const fetchEmployees = async () => {
  startLoading()
  error.value = null
  try {
    await api.initializeCsrf()
    employees.value = await api.getEmployees(searchQuery.value)
    factories.value = await api.getFactories()
  } catch (err) {
    console.error(err)
    if (err.response?.status === 401) {
      error.value = 'You are not logged in! Please log into the backend at http://localhost:8000/login first.'
    } else {
      error.value = 'Failed to load data. Is the backend running?'
    }
  } finally {
    stopLoading()
  }
}

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

const saveEmployee = async (formData) => {
  isSaving.value = true
  try {
    if (isEditing.value) {
      await api.updateEmployee(formData.id, formData)
    } else {
      await api.createEmployee(formData)
    }
    showModal.value = false
    fetchEmployees()
  } catch (err) {
    alert('Failed to save employee. Check your validation rules!')
    console.error(err)
  } finally {
    isSaving.value = false
  }
}

const deleteEmployee = async (id) => {
  if (!confirm('Are you sure you want to delete this employee?')) return
  
  deletingId.value = id
  try {
    await api.deleteEmployee(id)
    fetchEmployees()
  } catch (err) {
    alert('Failed to delete employee')
  } finally {
    deletingId.value = null
  }
}
</script>

<template>
  <div class="p-6 relative">
    
    <!-- Error Alert -->
    <Message v-if="error" severity="error" :closable="false" class="mb-4">
      {{ error }}
    </Message>

    <!-- Toolbar: Search & Add -->
    <div class="flex justify-between items-center mb-6">
      <IconField iconPosition="left" class="w-1/3">
        <InputIcon class="pi pi-search" />
        <InputText 
          v-model="searchQuery" 
          placeholder="Search by name..." 
          class="w-full"
        />
      </IconField>
      <Button label="Add Employee" icon="pi pi-plus" @click="openCreateModal" />
    </div>

    <!-- Data Table -->
    <DataTable 
      :value="employees" 
      :loading="isLoading" 
      dataKey="id" 
      stripedRows 
      responsiveLayout="scroll"
      emptyMessage="No employees found."
      class="border rounded-lg overflow-hidden"
    >
      <Column header="Name">
        <template #body="slotProps">
          <span class="font-medium">{{ slotProps.data.firstname }} {{ slotProps.data.lastname }}</span>
        </template>
      </Column>
      <Column field="email" header="Email"></Column>
      <Column field="phone" header="Phone"></Column>
      <Column header="Factory">
        <template #body="slotProps">
          <span v-if="slotProps.data.factory" class="px-2 py-1 bg-blue-900 text-blue-100 rounded text-sm">
            {{ slotProps.data.factory.factory_name }}
          </span>
          <span v-else class="text-gray-400 italic">N/A</span>
        </template>
      </Column>
      <Column header="Actions" :exportable="false" style="min-width:8rem">
        <template #body="slotProps">
          <div class="flex justify-start gap-2 -ml-3">
            <Button 
              icon="pi pi-pencil" 
              severity="secondary"
              text
              rounded 
              @click="openEditModal(slotProps.data)" 
              :disabled="deletingId === slotProps.data.id"
            />
            <Button 
              icon="pi pi-trash" 
              severity="danger"
              text
              rounded 
              @click="deleteEmployee(slotProps.data.id)" 
              :loading="deletingId === slotProps.data.id"
            />
          </div>
        </template>
      </Column>
    </DataTable>

    <!-- Create/Edit Modal (Extracted into Child Component!) -->
    <EmployeeFormModal 
      v-model:visible="showModal"
      :isEditing="isEditing"
      :employeeData="form"
      :factories="factories"
      :isSaving="isSaving"
      @save="saveEmployee"
    />

  </div>
</template>
