<template>
  <div class="alert alert-danger">{{ alertMessage }}</div>
</template>

<script>
export default {
  name: 'Error',
  props: {
    code: {
      type: Number,
      default: 404,
    },
    message: {
      type: String,
      default: 'Not Found',
    }
  },
  computed: {
    alertMessage() {
      return `${this.code}: ${this.message}`
    }
  }
};
</script>
