
importScripts(
  'https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js'
);
importScripts(
  'https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging-compat.js'
);

firebase.initializeApp({
  apiKey: '',
  authDomain: '',
  projectId: '',
  storageBucket: '',
  messagingSenderId: '',
  appId: ''
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(({ notification }) => {
  console.log('[firebase-messaging-sw.js] Received background message ');
  // Customize notification here
  const notificationTitle = notification.title;
  const notificationOptions = {
    body: notification.body,
  };

  if (notification.icon) {
    notificationOptions.icon = notification.icon;
  }

  self.registration.showNotification(notificationTitle, notificationOptions);
});