if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/kamus-definisi/sw.js')
        .then((reg) => console.log('service worker registered', reg))
        .catch((err) => console.log('service worker not registered', err))
}