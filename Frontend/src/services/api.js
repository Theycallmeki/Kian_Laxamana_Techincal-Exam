import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000/api',
  withCredentials: true,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
});

export default {
    async initializeCsrf() {
        return await axios.get('http://localhost:8000/sanctum/csrf-cookie', {
            withCredentials: true
        });
    },
    async getEmployees(searchQuery = '', page = 1) {
        const response = await apiClient.get('/employees', {
            params: { search: searchQuery, page: page }
        });
        return response.data;
    },
    async getFactories() {
        const response = await axios.get('/api/factories');
        return response.data;
    },
    async createEmployee(employeeData) {
        const response = await axios.post('/api/employees', employeeData);
        return response.data;
    },
    async updateEmployee(id, employeeData) {
        const response = await axios.put(`/api/employees/${id}`, employeeData);
        return response.data;
    },
    async deleteEmployee(id) {
        return await axios.delete(`/api/employees/${id}`);
    }
};
