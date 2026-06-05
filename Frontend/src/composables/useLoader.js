import { ref } from 'vue'

// Global state: declaring this outside the function means all components share the exact same state.
const isLoading = ref(false)

export function useLoader() {
  const startLoading = () => {
    isLoading.value = true
  }

  const stopLoading = () => {
    isLoading.value = false
  }

  return {
    isLoading,
    startLoading,
    stopLoading
  }
}
