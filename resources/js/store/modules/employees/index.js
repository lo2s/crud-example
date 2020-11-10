import axios from 'axios';

export default {
  namespaced: true,
  state: {
    employees: [],
    currentEmployee: null,
    errors: null,
  },
  mutations: {
    setItem(state, { key, value }) {
      state[key] = value;
    },
    clearErrors(state) {
      state.errors = null;
    }
  },
  actions: {
    async getEmployees({ commit }) {
      try {
        commit('clearErrors');

        const { data } = await axios.get('/api/employees');

        commit('setItem', {
          key: 'employees',
          value: data,
        });

        return true;
      } catch (error) {
        console.error(error);

        return false;
      }
    },

    async getEmployee({ commit, state }, employeeId) {
      try {
        commit('clearErrors');

        const { data } = await axios.get(`/api/employees/${ employeeId }`);

        commit('setItem', {
          key: 'currentEmployee',
          value: data,
        });

        return true;
      } catch (error) {
        console.error(error);

        return false;
      }
    },

    async storeEmployee({ commit, state }, formData) {
      try {
        commit('clearErrors');

        const { data } = await axios.post('/api/employees', formData);

        commit('setItem', {
          key: 'employees',
          value: [...state.employees, data],
        });

        return true;
      } catch (error) {
        console.error(error);

        commit('setItem', {
          key: 'errors',
          value: error.response.data.errors,
        });

        return false;
      }
    },

    async updateEmployee({ commit, state }, { employeeId, formData }) {
      try {
        commit('clearErrors');

        const { data } = await axios.patch(`/api/employees/${ employeeId }`, formData);

        commit('setItem', {
          key: 'currentEmployee',
          value: data,
        });

        commit('setItem', {
          key: 'employees',
          value: [...state.employees].map(employee => employee.id === employeeId ? data : employee),
        });

        return true;
      } catch (error) {
        console.error(error);

        commit('setItem', {
          key: 'errors',
          value: error.response.data.errors,
        });

        return false;
      }
    },

    async deleteEmployee({ commit, state }, employeeId) {
      try {
        commit('clearErrors');

        await axios.delete(`/api/employees/${ employeeId }`);

        commit('setItem', {
          key: 'employees',
          value: [...state.employees].filter(employee => employee.id !== employeeId),
        });

        return true;
      } catch (error) {
        console.error(error);

        return false;
      }
    },
  },
};
