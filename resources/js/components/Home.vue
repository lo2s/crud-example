<template>
  <div class="app">
    <b-navbar
      type="dark"
      variant="dark"
      class="mb-2"
    >
      <b-navbar-nav>
        <router-link
          v-for="navLink in navLinks"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
          :to="navLink.href"
          :key="navLink.text"
        >
          <b-nav-item
            :active="isExactActive"
            :href="href"
            @click="navigate"
          >
            {{ navLink.text }}
          </b-nav-item>
        </router-link>
      </b-navbar-nav>
    </b-navbar>

    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      navLinks: [
        {
          href: { name: 'home' },
          text: 'Home',
        },
        {
          href: { name: 'employees-list' },
          text: 'Employees',
        },
      ],
    };
  },
};
</script>
