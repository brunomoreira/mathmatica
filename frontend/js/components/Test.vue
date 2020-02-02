<template>
  <div class="hello wrapper">
    <h1>Test Component!</h1>
    <div class="user" v-if="!loading && user">
      <p>Username: {{ user.username }}</p>
      <p>Email: {{ user.email }}</p>
      <img :src="user.avatar" alt="user avatar">
    </div>
    <md-spinner :md-size="20" :md-stroke="1" md-indeterminate v-if="loading"></md-spinner>
  </div>
</template>

<script>

import store from '../store'

export default {
  name: 'test',
  data() {
    return {
      user: null,
      loading: false
    }
  },
  created() {
    return this.fetchUser();
  },
  watch: {
    // call again the method if the route changes
    '$route': 'fetchUser'
  },
  methods: {
    fetchUser() {

      this.loading = true

      setTimeout(_ => {

        this.user = store.state.user

        this.loading = false

      }, 2000)

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
