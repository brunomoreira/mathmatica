<template>
  <div id="app" class="main-container">
    <navbar></navbar>
    <transition name="fade">
      <router-view></router-view>
    </transition>
    <loading v-if="loading"></loading>
    <transition-group name="slide">
      <notification v-for="notification in notifications" 
                    :key="notification.id" 
                    :notification="notification">
      </notification>
    </transition-group>  
  </div>
</template>

<script>

import Navbar from './components/Navbar'
import Loading from './components/Loading'
import Login from './components/Login'
import Notification from './components/Notification'
import Test from './components/Test' // Remove In Production

export default {
  name: 'app',
  computed: {
    loading() {
      return this.$store.state.loading
    },
    notifications() {
      return this.$store.state.notifications
    }
  },
  components: {
    Navbar, Loading, Login, Notification, Test
  }
}
</script>

<style lang="scss">

$red: #e53935;
$blue: #2196F3;
$green: #43a047;

:root
{
  font-size: 16px;
}

body
{
  height: 100vh;
  margin: 0;
  padding: 0;
  position: relative;
  overflow-x: hidden;
}

h1, h2, h3, h4, h5,
p,
small
{
  margin: 0;
  padding: 0;
}

.main-container
{
  width: 100%;
  margin: 0 auto;
  height: 100%;
  display: flex;
  flex-direction: column;
}

// Material Vue Overrides
.md-theme-default.md-input-container.md-input-invalid label, 
.md-theme-default.md-input-container.md-input-invalid input, 
.md-theme-default.md-input-container.md-input-invalid textarea, 
.md-theme-default.md-input-container.md-input-invalid .md-error, 
.md-theme-default.md-input-container.md-input-invalid .md-count, 
.md-theme-default.md-input-container.md-input-invalid .md-icon:not(.md-icon-delete)
{
  color: $red;
}

.md-accent
{
  background: $red;
}

.md-tabs-navigation-container
{
    overflow: hidden !important;
}

.md-tabs-content
{
  margin-top: 20px;
}

label,
.md-input-focused
{
  color: $blue !important;
}

.md-input
{
  border-bottom: 1px solid $blue !important;
}

// Animations - [ Credits ] -> https://github.com/daneden/animate.css/
@keyframes fadeInUp 
{
  from {
    opacity: 0;
    transform: translate3d(0, 100%, 0);
  }

  to {
    opacity: 1;
    transform: none;
  }
}

.slide-enter-active 
{
  animation: fadeInUp .5s;
}

.slide-leave-active 
{
  animation: fadeInUp .5s reverse;
}

.md-sidenav-content
{
    display: flex;
    flex-direction: column;

    .sidenav-links { flex: 1; }

    .logout-sidenav-container
    {
        align-self: center;
        margin-bottom: 20px;
    }

}

.md-menu-content
{
  .md-card
  {
      box-shadow: none;
  }

  .md-list
  {
    padding: 0 0 10px 0;
  }

  .md-card-header
  {
    background: mediumseagreen;
    padding: 20px;
  }

  .md-title
  {
    text-align: center;
    color: white;
    font-weight: 700;
  }

  .router-link-active
  {
    background: $blue;
    color: white;
  }
}


</style>