'use strict';

self.addEventListener('install', function(event) {
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        let msg = e.data.json();
        console.log(msg);
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions
        }));
    }
});

// // свой обработчик клика по уведомлению
// self.addEventListener('notificationclick', function(event) {
//     // извлекаем адрес перехода из параметров уведомления
//     const target = event.notification.actions[0].action || '/';
//     event.notification.close();
//
//     // этот код должен проверять список открытых вкладок и переключатся на открытую
//     // вкладку с ссылкой если такая есть, иначе открывает новую вкладку
//     event.waitUntil(clients.matchAll({
//         type: 'window',
//         includeUncontrolled: true
//     }).then(function(clientList) {
//         // clientList почему-то всегда пуст!?
//         for (let i = 0; i < clientList.length; i++) {
//             let client = clientList[i];
//
//             if(client.url.includes("https://orders.kfkcom.ru/")) {
//                 console.log("Contains URL");
//                 return client.focus();
//             }
//
//             // if (client.url == target && 'focus' in client) {
//             //     return client.focus();
//             // }
//         }
//
//         // Открываем новое окно
//         return clients.openWindow(target);
//     }));
// });


self.addEventListener('notificationclick', function (event) {
    event.notification.close();
const target = event.notification.actions[0].action || '/';
    event.waitUntil(clients.openWindow(target));
});
