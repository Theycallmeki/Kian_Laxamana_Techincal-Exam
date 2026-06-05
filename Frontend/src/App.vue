<script setup>
import EmployeeList from './components/EmployeeList.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-100 text-gray-900 font-sans p-8">
    <div class="max-w-7xl mx-auto">
      <header class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
          Employees <span class="text-sm font-normal text-gray-500">(Vue SPA)</span>
        </h1>
      </header>

      <!-- Here is where our main logic will go -->
      <EmployeeList />
    </div>
  </div>
</template>
