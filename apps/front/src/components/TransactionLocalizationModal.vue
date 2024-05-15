<template>
  <div class="modal">
    <h2>Select Location</h2>
    <div v-if="loading">Loading nearby locations...</div>
    <div v-else>
      <ul>
        <li v-for="(location, index) in nearbyLocations" :key="index" @click="selectLocation(location)">
          {{ location.name }} - {{ location.address }}
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
      nearbyLocations: [],
      loading: true
    };
  },
  mounted() {
    this.fetchNearbyLocations();
  },
  methods: {
    fetchNearbyLocations() {
      const latitude = 123.456; 
      const longitude = 789.012; 
      
      const apiKey = 'YOUR_GOOGLE_PLACES_API_KEY'; key

      const apiUrl = `https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=${latitude},${longitude}&radius=1000&key=${apiKey}`;

      axios.get(apiUrl)
        .then(response => {
          const nearbyLocations = response.data.results.map(result => ({
            name: result.name,
            address: result.vicinity
          }));
          
          // Update nearbyLocations data
          this.nearbyLocations = nearbyLocations;
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching nearby locations:', error);
        });
    },
    selectLocation(location) {
      this.$emit('locationSelected', location);
    }
  }
};
</script>

<style scoped>
</style>