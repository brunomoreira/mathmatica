<template>
    <div class="notification-wrapper" v-if="notification" @click="clearNotification(notification.id)">
        <div class="notification" :class="notification.type">
            <p>
                <md-icon v-if="notification.type == 'error'">warning</md-icon>
                <md-icon v-if="notification.type == 'success'">check_circle</md-icon>
                <md-icon v-if="notification.type == 'info'">info</md-icon>
                <span>{{ notification.body }}</span>
            </p>
        </div>
    </div>
</template>

<script>

import store from '../store'

export default {
  name: 'notification',
  props: ['notification'],
  methods: {
      clearNotification(id) {
          return store.commit('clearNotification', id)
      }
  }
}

</script>

<style lang="scss" scoped>

    .notification-wrapper
    {
        position: fixed;
        bottom: 20px;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        z-index: 1000;
        &:hover { cursor: pointer; }

        .notification
        {
            padding: 10px 20px;
            position: relative;

            &.error { background: red; }
            &.success { background: mediumseagreen; }
            &.info { background: #2196F3; }

            p
            {
                color: white;
                span { font-weight: bold; }
                i { margin-right: 10px; margin-left: -10px; font-size: 1.5rem; }
            }
        }
    }

</style>

