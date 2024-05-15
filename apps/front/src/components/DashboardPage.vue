<template>
    <div>
      <h1>Dashboard</h1>
      <div v-if="loading">Loading dashboard data...</div>
      <div v-else>
        <div v-if="Object.keys(userScores).length">
          <h2>User Scores:</h2>
          <ul>
            <li v-for="(score, user) in userScores" :key="user">
              {{ user }}: {{ score }}
            </li>
          </ul>
        </div>
        <div v-if="pendingTransactionsCount !== null">
          <h2>Pending Transactions:</h2>
          <p>Number of pending transactions: {{ pendingTransactionsCount }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  // Import any necessary dependencies, e.g., Axios for HTTP requests
  import axios from 'axios';
  
  export default {
    data() {
      return {
        userScores: {},
        pendingTransactionsCount: null,
        loading: true
      };
    },
    created() {
      this.fetchDashboardData();
    },
    methods: {
      fetchDashboardData() {
        axios.get('/api/dashboard')
          .then(response => {
            // Update component data with dashboard data from response
            this.userScores = response.data.user_scores || {};
            this.pendingTransactionsCount = response.data.pending_transactions_count !== undefined ? response.data.pending_transactions_count : null;
            this.loading = false;
          })
          .catch(error => {
            console.error('Error fetching dashboard data:', error);
          });
      }
    }
  };
  </script>
  
  <style scoped>
  </style>