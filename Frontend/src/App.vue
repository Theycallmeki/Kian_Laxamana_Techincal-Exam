<script setup>
import EmployeeList from './components/EmployeeList.vue'
</script>

<template>
  <div class="min-h-screen font-sans p-4 w-full">
    <div class="w-full">
      <header class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-200">
          Employees <span class="text-sm font-normal text-gray-400">(Vue SPA)</span>
        </h1>
      </header>

      <!-- Here is where our main logic will go -->
      <EmployeeList />
    </div>
  </div>
</template>
