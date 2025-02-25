const CACHE_NAME = 'projeto-cache-v2';
const urlsToCache = [

];

// Instalando o Service Worker e cacheando os arquivos essenciais
self.addEventListener('install', async (event) => {
    event.waitUntil(
        caches.keys().then(async (cacheNames) => {
            // Remove caches antigos
            await Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );

            // Abre o cache e armazena os arquivos essenciais
            const cache = await caches.open(CACHE_NAME);
            return cache.addAll(urlsToCache);
        })
    );
    console.log('Service Worker instalado.');
});

// Servindo os arquivos do cache e verificando se há atualizações
self.addEventListener('fetch', async (event) => {
    event.respondWith(
        (async () => {
            const cachedResponse = await caches.match(event.request);

            // Se o arquivo estiver no cache, retorna ele imediatamente
            if (cachedResponse) {
                const fetchPromise = fetch(event.request)
                    .then(async (networkResponse) => {
                        // Verifica se a resposta da rede é válida
                        if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
                            return networkResponse;
                        }

                        // Atualiza o cache com a nova versão do arquivo
                        const cache = await caches.open(CACHE_NAME);
                        cache.put(event.request, networkResponse.clone());
                        return networkResponse;
                    })
                    .catch(() => cachedResponse); // Retorna o cache se não conseguir acessar a rede

                return cachedResponse || fetchPromise; // Retorna o cache imediatamente, mas atualiza em background
            }

            // Se não estiver no cache, busca da rede
            return fetch(event.request);
        })()
    );
});