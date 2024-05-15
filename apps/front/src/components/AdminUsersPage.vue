<template>
    <div>
      <h1>Admin Users</h1>
      <div v-if="loading">Loading users...</div>
      <div v-else>
        <ul>
          <li v-for="user in users" :key="user.id">
            {{ user.firstName }} {{ user.lastName }} - Email: {{ user.email }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  // Import any necessary dependencies
  import axios from 'axios';
  
  export default {
    data() {
      return {
        users: [],
        loading: true
      };
    },
    created() {
      this.fetchUsers();
    },
    methods: {
      fetchUsers() {
        // Make an API call to fetch users from backend
        axios.get('/api/admin/users')
          .then(response => {
            this.users = response.data;
            this.loading = false;
          })
          .catch(error => {
            console.error('Error fetching users:', error);
          });
      }
    }
  };
  </script>
  
  <style scoped>
  </style>