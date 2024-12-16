<template>
    <div class="notification-container">
      <div
        v-for="(notification, index) in notifications"
        :key="index"
        class="notification"
        :class="{ show: notification.show }"
      >
        <span>{{ notification.message }}</span>
        <button class="close-btn" @click="removeNotification(index)">×</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        notifications: [],
      };
    },
    methods: {
      addNotification(message) {
        const notification = { message, show: true };
        this.notifications.push(notification);
  
        // Auto-remove notification after 3 seconds
        setTimeout(() => {
          this.removeNotification(this.notifications.indexOf(notification));
        }, 3000);
      },
      removeNotification(index) {
        if (index > -1) this.notifications.splice(index, 1);
      },
    },
  };
  </script>
  
  <style scoped>
  .notification-container {
    position: fixed;
    top: 80px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 1000;
  }
  
  .notification {
    background: #1c1c1c;
    color: #ffffff;
    padding: 10px 15px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    opacity: 0;
    transform: translateX(100%);
    transition: opacity 0.5s ease, transform 0.5s ease;
  }
  
  .notification.show {
    opacity: 1;
    transform: translateX(0);
  }
  
  .close-btn {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    margin-left: 10px;
  }
  </style>
  