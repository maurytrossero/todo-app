import { createApp } from 'vue';  // Importar Vue
import App from './App.vue';      // Importar el componente principal de Vue
import router from './router';    // Importar el router que creaste
import store from './store';      // Importar el store de Vuex
import './axios'; 



import './bootstrap';  // Importar el archivo bootstrap.js como ya lo tenías

// Crear la instancia de la aplicación Vue
const app = createApp(App);

// Usar el router en la aplicación Vue
app.use(router);
app.use(store);


// Montar la aplicación en el div con id "app" en tu archivo Blade
app.mount('#app');
