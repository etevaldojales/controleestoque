const CACHE_NAME = 'controle-de-estoque-mobile-v1';
const ASSETS = [
  'index.php',
  'css/mobile.css',
  'js/mobile.js',
  'manifest.php',
  '../img/logo.png'
];

self.addEventListener('install', (e) => {
  e.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS);
    })
  );
});

self.addEventListener('fetch', (e) => {
  e.respondWith(
    caches.match(e.request).then((response) => {
      return response || fetch(e.request);
    })
  );
});
