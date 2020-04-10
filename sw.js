// Copyright 2016 Google Inc.

// limitations under the License.

var dataCacheName = 'Tabelo-v19';
var cacheName = 'tabeloPWA-final-19';
var filesToCache = [
  '/',
  'index.html',
  'js/app.js',
  'js/closeapp.js',
  'css/bootstrap.min.css',
  'css/style.css',
  'lib/angular.min.js',
  'lib/angular-route.min.js',
  'js/bootstrap.bundle.min.js',
  'img/icon-menu.png',
  'img/home.png',
  'img/tabelo-logo.png',
  'img/pashulevech.jpg',
  'img/medicohelp.jpg',
  'img/khet-pedash.jpg',
  'img/khet-ozaro.jpg',
  'img/insurance.jpg',
  'img/govtschemes.jpg',
  'img/pashuloan.jpg',
  'img/pashuhelp.jpg',
  'img/photo-video.jpg',
  'img/loader.gif',
  'img/cows.jpg',
  'img/buffalos.jpg',
  'img/bull.jpg',
  'img/horses.jpg',
  'img/dogs.jpg',
  'img/other.jpg',
  'img/profileicon.png',
  'img/date.png',
  'template/home.html',
  'template/categories.html',
  'template/list.html',
  'template/detail.html',
  'template/about.html',
  'template/discuss.html',
  'template/forum.html',
  'template/gallery.html',
  'template/insertadv.html',
  'template/insurance.html',
  'template/loan.html',
  'template/login.html',
  'template/newquery.html',
  'template/policy.html',
  'template/schemes.html'
];


self.addEventListener('install', function(e) {
  console.log('[ServiceWorker] Install');
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log('[ServiceWorker] Caching app shell');
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('activate', function(e) {
  console.log('[ServiceWorker] Activate');
  e.waitUntil(
    caches.keys().then(function(keyList) {
      return Promise.all(keyList.map(function(key) {
        if (key !== cacheName && key !== dataCacheName) {
          console.log('[ServiceWorker] Removing old cache', key);
          return caches.delete(key);
        }
      }));
    })
  );
  
  return self.clients.claim();
});

self.addEventListener('message', function (event) {
  if (event.data.action === 'skipWaiting') {
    self.skipWaiting();
  }
});

self.addEventListener('fetch', function(e) {
  console.log('[Service Worker] Fetch', e.request.url);
  var dataUrl = 'https://tabelo.in/#!/list';
  if (e.request.url.indexOf(dataUrl) > -1) {
   
    e.respondWith(
      caches.open(dataCacheName).then(function(cache) {
        return fetch(e.request).then(function(response){
          cache.put(e.request.url, response.clone());
          return response;
        });
      })
    );
  } else {
   
    e.respondWith(
      caches.match(e.request).then(function(response) {
        return response || fetch(e.request);
      })
    );
  }
});