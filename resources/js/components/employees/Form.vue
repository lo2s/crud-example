<template>
  <div class="employee-new container">
    <h1 class="mb-4">Create New Employee</h1>

    <div class="alert alert-danger" v-if="errors">{{ errors }}</div>

    <b-form @submit.prevent="formHandler">
      <b-form-input
        class="mb-3"
        v-model="form.name"
        type="text"
        required
        placeholder="Enter name"
      />

      <b-form-input
        class="mb-3"
        v-model="form.email"
        type="email"
        required
        placeholder="Enter email"
      />

      <b-form-input
        class="mb-3"
        v-model="form.phone"
        type="text"
        required
        placeholder="Enter phone"
      />

      <b-form-input
        class="mb-3"
        v-model="form.salary"
        type="number"
        step=any
        required
        placeholder="Enter salary"
      />

      <b-button
        variant="primary"
        type="submit"
      >
        Submit
      </b-button>
    </b-form>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
  name: 'Form',
  data() {
    return {
      employeeId: null,
      form: {
        name: '',
        email: '',
        phone: '',
        salary: null,
      },
    };
  },
  computed: {
    ...mapState('employees', [
      'currentEmployee',
      'errors',
    ]),
  },
  methods: {
    ...mapActions('employees', [
      'getEmployee',
      'storeEmployee',
      'updateEmployee',
    ]),
    async formHandler() {
      const result = this.employeeId
        ? await this.updateEmployee({ employeeId: this.employeeId, formData: this.form })
        : await this.storeEmployee(this.form);

      this.$bvToast.toast(result ? 'OK' : 'Error', {
        title: 'Employee Alert',
        autoHideDelay: 5000,
        appendToast: true,
        variant: result ? 'success' : 'danger',
      });

      if (result) {
        await this.$router.push({ name: 'employees-list' });
      }
    },
  },
  async created() {
    if (this.$route.params.id) {
      this.employeeId = this.$route.params.id;
      await this.getEmployee(this.employeeId);

      this.form.name = this.currentEmployee.name;
      this.form.email = this.currentEmployee.email;
      this.form.phone = this.currentEmployee.phone;
      this.form.salary = this.currentEmployee.salary;
    }
  },
};
</script>
