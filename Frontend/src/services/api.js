import axios from 'axios';

export default {
    async initializeCsrf() {
        return await axios.get('/sanctum/csrf-cookie');
    },
    async getEmployees(searchQuery = '') {
        const response = await axios.get('/api/employees', {
            params: { search: searchQuery }
        });
        return response.data.data || response.data;
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
