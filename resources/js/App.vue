<template>
  <div class="app-container">
    <h1>Aplicación TO DO con Vue 3 y Laravel 11</h1>
    <router-view></router-view> <!-- Aquí Vue Router cargará las rutas -->
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style scoped>
/* Estilos básicos para el contenedor */
.app-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background-color: #f0f0f0;
  padding: 20px;
}

/* Estilos para el título */
h1 {
  font-family: 'Poppins', sans-serif;
  color: #333;
  text-align: center;
  margin-bottom: 30px;
  font-size: 2.5rem;
}

/* Estilos para el contenido cargado por Vue Router */
router-view {
  width: 100%;
  max-width: 1200px;
  background-color: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
</style>
