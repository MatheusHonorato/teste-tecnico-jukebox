import { createApp } from 'vue';
import { initializeApp } from 'firebase/app';
import { getFirestore } from 'firebase/firestore';
import router from './router';
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import './assets/main.css';

const firebaseApp = initializeApp({
  apiKey: process.env.VUE_APP_API_KEY,
  authDomain: process.env.VUE_APP_AUTH_DOMAIN,
  projectId: process.env.VUE_APP_PROJECT_ID,
  storageBucket: process.env.VUE_APP_STORAGE_BUCKET,
  messagingSenderId: process.env.VUE_APP_MESSAGING_SENDER_ID,
  appId: process.env.VUE_APP_APP_ID
});

const app = createApp(App);
app.use(router);
const fb = getFirestore(firebaseApp);
app.config.globalProperties.$fb = fb;
app.mount('#app');
