
<template>
  <div>
    <div id="map"></div>
  </div>
</template>

<script>
export default {
  mounted() {
    // Initialize Google Map
    this.map = new google.maps.Map(document.getElementById('map'), {
      center: { lat: 48.87678, lng: -57.86443 },
      zoom: 15
    });
  }
};
</script>

<style scoped>
#map {
  height: 400px;
  width: 100%;
}
</style>