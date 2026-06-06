<script setup>
import { ref, watch } from 'vue'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import Button from 'primevue/button'

const props = defineProps({
  visible: Boolean,
  isEditing: Boolean,
  employeeData: Object,
  factories: Array,
  isSaving: Boolean
})

const emit = defineEmits(['update:visible', 'save'])

const form = ref({ ...props.employeeData })

// Watch for changes when parent opens modal with new data
watch(() => props.employeeData, (newVal) => {
  form.value = { ...newVal }
}, { deep: true })

const save = () => {
  emit('save', form.value)
}
</script>

<template>
  <Dialog 
    :visible="visible" 
    @update:visible="(val) => emit('update:visible', val)"
    :header="isEditing ? 'Edit Employee' : 'Add New Employee'" 
    :modal="true" 
    class="w-full max-w-md"
  >
    <form @submit.prevent="save" class="flex flex-col gap-4 mt-2">
      <div class="flex flex-col gap-1">
        <label class="font-bold text-sm">First Name *</label>
        <InputText v-model="form.firstname" required />
      </div>
      
      <div class="flex flex-col gap-1">
        <label class="font-bold text-sm">Last Name *</label>
        <InputText v-model="form.lastname" required />
      </div>

      <div class="flex flex-col gap-1">
        <label class="font-bold text-sm">Factory</label>
        <Select 
          v-model="form.factory_id" 
          :options="factories" 
          optionLabel="factory_name" 
          optionValue="id" 
          placeholder="-- Select Factory --" 
          class="w-full"
        />
      </div>

      <div class="flex flex-col gap-1">
        <label class="font-bold text-sm">Email</label>
        <InputText v-model="form.email" type="email" />
      </div>

      <div class="flex flex-col gap-1">
        <label class="font-bold text-sm">Phone</label>
        <InputText v-model="form.phone" />
      </div>

      <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-100">
        <Button label="Cancel" icon="pi pi-times" severity="secondary" text @click="emit('update:visible', false)" :disabled="isSaving" />
        <Button label="Save" icon="pi pi-check" type="submit" :loading="isSaving" />
      </div>
    </form>
  </Dialog>
</template>
