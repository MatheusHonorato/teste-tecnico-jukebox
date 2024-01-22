<template>
  <header>
    <span v-if="notificationMessage">{{ notificationMessage }}</span>
    <MenuComponent />
  </header>
  <div class="container">
    <router-view />
  </div>
</template>

<script>
import { getMessaging, getToken, onMessage } from 'firebase/messaging';
import app from '@/helpers/firebase';
import MenuComponent from '@/components/MenuComponent.vue';

export default {
  name: 'App',
  data() {
    return {
      notificationMessage: '',
    };
  },
  setup() {
    const messaging = getMessaging(app);

    onMessage(messaging, (payload) => {
      const options = {
        body: payload.notification.body,
        requireInteraction: true,
      };
      new Notification(payload.notification.title, options);
    });

    getToken(messaging, { vapidKey: process.env.VUE_APP_FIREBASE_PUBLIC_KEYS })
      .then((currentToken) => {
        const uid = localStorage.userUid;

        if (currentToken && uid) {
          const formData = new FormData();
          formData.append('fcm_token', currentToken);

          navigator.sendBeacon(
            `${process.env.VUE_APP_BASE_URL}/tokens/${uid}`,
            formData
          );
        }
        if (!currentToken) {
          console.log('No registration token available. Request permission to generate one.');
        }
      }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
      });
  },
  components: {
    MenuComponent
  }
};
</script>
