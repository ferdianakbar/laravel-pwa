import { precacheAndRoute } from 'workbox-precaching';
import { registerRoute } from 'workbox-routing';
import { NetworkFirst, CacheFirst} from 'workbox-strategies';
// Used to limit entries in cache, remove entries after a certain period of time
import { ExpirationPlugin } from 'workbox-expiration';

precacheAndRoute(self.__WB_MANIFEST || [
    {
        url: '/',
        revision: Date.now()
    },
    {
        url: '/app.js',
        revision: Date.now()
    },
    {
        url: '/app.css',
        revision: Date.now()
    },
]);

// Script and Style
registerRoute(
    new RegExp('.(?:js|css)$'),
    new NetworkFirst({
        cacheName: 'scriptAndStyle'
    }),
)

// Assets
registerRoute(
    new RegExp('.(?:jpg|png|gif|svg|ico)$'),
    new CacheFirst({
        cacheName: 'assets',
        plugins: [
            new ExpirationPlugin({
                maxEntries: 20,
                purgeOnQuotaError: true,
            })
        ]
    })
)

// Cross Origin
registerRoute(
    new RegExp('.*(?:googleapis|gstatic|fontawesome).com.*$'),
    new NetworkFirst({
        cacheName: 'cross-origin'
    })
)

