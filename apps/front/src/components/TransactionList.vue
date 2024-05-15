<template>
  <div>
    <h1>Transactions</h1>
    <div v-if="loading">Loading transactions...</div>
    <div v-else>
      <ul>
        <li v-for="(transaction, index) in transactions" :key="index">
          <!-- Display transaction details -->
          {{ transaction.description }} - Amount: {{ transaction.amount }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      transactions: [],
      loading: true
    };
  },
  mounted() {
    this.fetchTransactions();
  },
  methods: {
    fetchTransactions() {
      axios.get('/api/transactions')
        .then(response => {
          this.transactions = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching transactions:', error);
        });
    }
  }
};
</script>

<style scoped>
</style>