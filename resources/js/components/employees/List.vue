<template>
  <div class="employees container-fluid">
    <h1 class="mb-3">Employees List</h1>

    <router-link :to="{ name: 'employees-new' }">
      <b-button variant="outline-primary">Create</b-button>
    </router-link>

    <b-table
      striped
      bordered
      :items="employees"
      :busy="isLoading"
      :fields="['name', 'email', 'phone', 'salary', 'created_at', 'actions']"
      class="mt-3"
    >
      <template #table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>

      <template #cell(actions)="row">
        <router-link :to="{ name: 'employees-update', params: { id: row.item.id } }">
          <b-button variant="warning" size="sm" class="mr-1">
            edit
          </b-button>
        </router-link>
        <b-button variant="danger" size="sm" @click="deleteEmployee(row.item.id)">
          delete
        </b-button>
      </template>
    </b-table>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
  name: 'List',
  data() {
    return {
      isLoading: true,
    };
  },
  computed: {
    ...mapState('employees', [
      'employees',
    ]),
  },
  methods: {
    ...mapActions('employees', [
      'getEmployees',
      'deleteEmployee',
    ]),
  },
  async created() {
    await this.getEmployees();
    this.isLoading = false;
  },
};
</script>
