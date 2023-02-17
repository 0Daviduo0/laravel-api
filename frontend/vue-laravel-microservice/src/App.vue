<script>

import axios from 'axios';

export default {
  mounted() {
    axios.get('http://127.0.0.1:8000/api/v1/movie/all')
    .then(res => {
      
      const data = res.data;
      const success = data.success;
      const movies = data.response;

      console.log(movies);
      // console.log(movies); non sta funzionando

    })
    .catch(err => console.error(err));
  }
}

</script>

<template>
 
  <h1>Hello world</h1>

</template>

<style scoped>

</style>
