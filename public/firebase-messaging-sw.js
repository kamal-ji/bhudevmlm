// firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/10.5.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.5.0/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: "AIzaSyCCpefxXHckoxYQfEFEI0qpVokZ5HCRGMI",
  authDomain: "tiara-adb0a.firebaseapp.com",
  projectId: "tiara-adb0a",
  storageBucket: "tiara-adb0a.firebasestorage.app",
  messagingSenderId: "424284680643",
  appId: "1:424284680643:web:8e3b6bc8067073cf0b8d76",
  measurementId: "G-B0FQY3FCD1"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/firebase-logo.png', // Make sure this file exists in your public folder
    badge: '/firebase-logo.png', // Optional badge icon
    data: payload.data || {} // Pass any data
  };

  // Show notification
  return self.registration.showNotification(notificationTitle, notificationOptions);
});

// Optional: Handle notification click
self.addEventListener('notificationclick', function(event) {
  console.log('Notification click received.', event);
  
  event.notification.close();
  
  // Handle click action - you can open a specific URL
  event.waitUntil(
    clients.matchAll({type: 'window'}).then(function(clientList) {
      // Focus on existing window or open new one
      for (const client of clientList) {
        if (client.url === '/' && 'focus' in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow('/');
      }
    })
  );
});