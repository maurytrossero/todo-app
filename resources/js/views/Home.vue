<template>
  <!-- Incluir la barra de navegación -->
  <Navbar />
  <div class="home-container">
    <h1>Página Principal</h1>
    <h3 class="welcome-title">Bienvenido a la Aplicación de Notas To Do</h3>
    <p class="welcome-text">
      Hola y bienvenido a nuestra aplicación de notas To Do, un espacio diseñado para ayudarte a organizar tus ideas y tareas de manera sencilla y eficiente. Aquí podrás crear, editar y gestionar tus notas de una forma intuitiva.
    </p>

    <h3 class="section-title">¿Qué puedes hacer aquí?</h3>
    <ul class="features-list">
      <li>Crear y gestionar tus notas: Añade títulos, descripciones y etiquetas para categorizar tus ideas.</li>
      <li>Mantén el control del tiempo: Establece fechas de vencimiento y no olvides tus tareas importantes.</li>
      <li>Acceso fácil y rápido: Inicia sesión de manera segura y accede a tus notas desde cualquier lugar.</li>
    </ul>

    <h3 class="section-title">Desarrollo de la Aplicación</h3>
    <p class="development-text">
      Esta aplicación ha sido desarrollada con las mejores prácticas utilizando Laravel y Vue.js.
    </p>
    
  </div>
  <Footer/>
</template>

<script>
import Navbar from "@/components/Navbar.vue"; // Importa el componente Navbar
import Footer from "@/components/Footer.vue"; // Importa el componente Footer
export default {
  components: {
    Navbar, // Declara el componente
    Footer
  },
  name: 'Home'
}
</script>

<style scoped>
/* Contenedor principal */
.home-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start; /* Alinea el contenido hacia arriba */
  height: 90vh; /* Ajustar para que no ocupe el 100% y dé más espacio */
  background-color: #f5f5f5;
  padding: 20px;
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}

/* Estilo para el título */
h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 10px; /* Menos margen inferior */
  text-align: center;
}

/* Estilo para los títulos de sección */
.section-title, .welcome-title {
  font-family: 'Poppins', sans-serif;
  font-size: 1.8rem; /* Aumentar el tamaño de fuente */
  color: #007bff; /* Color azul para destacar */
  margin: 20px 0; /* Espaciado vertical */
  text-align: center; /* Centrar el texto */
}

/* Estilo para el texto de bienvenida */
.welcome-text {
  font-family: 'Poppins', sans-serif; /* Usar la misma fuente */
  font-size: 1.1rem; /* Tamaño de fuente cómodo para lectura */
  color: #555; /* Color de texto más suave */
  line-height: 1.6; /* Espaciado entre líneas para mayor legibilidad */
  margin-bottom: 20px; /* Espacio inferior para separar del contenido siguiente */
  max-width: 800px; /* Ancho máximo para evitar líneas muy largas */
  text-align: justify; /* Justifica el texto para una mejor presentación */
  padding: 10px; /* Añadir un poco de relleno */
  background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco semi-transparente */
  border-radius: 10px; /* Bordes redondeados */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil para dar profundidad */
}

/* Estilo para la lista de características */
.features-list {
  list-style-type: disc; /* Tipo de lista con viñetas */
  margin: 20px 0; /* Espaciado superior e inferior */
  padding-left: 20px; /* Espaciado a la izquierda */
  font-family: 'Poppins', sans-serif; /* Usar la misma fuente */
  font-size: 1.1rem; /* Tamaño de fuente cómodo para lectura */
  color: #555; /* Color de texto más suave */
  max-width: 800px; /* Ancho máximo para evitar líneas muy largas */
}

/* Estilo para el texto de desarrollo */
.development-text {
  font-family: 'Poppins', sans-serif; /* Usar la misma fuente */
  font-size: 1.1rem; /* Tamaño de fuente cómodo para lectura */
  color: #555; /* Color de texto más suave */
  line-height: 1.6; /* Espaciado entre líneas para mayor legibilidad */
  margin-bottom: 20px; /* Espacio inferior para separar del contenido siguiente */
  max-width: 800px; /* Ancho máximo para evitar líneas muy largas */
  text-align: justify; /* Justifica el texto para una mejor presentación */
}

/* Estilo para la navegación */
nav ul {
  list-style: none;
  padding: 0;
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
  justify-content: center;
}

/* Estilo para los elementos de la lista */
nav ul li {
  font-size: 1.2rem;
}

/* Estilos para los enlaces */
.nav-link {
  text-decoration: none;
  color: #007bff;
  font-weight: 600;
  position: relative;
  transition: color 0.3s ease;
}

/* Efecto de hover */
.nav-link:hover {
  color: #0056b3;
}

/* Pseudo-elemento para el subrayado */
.nav-link::after {
  content: '';
  display: block;
  width: 100%;
  height: 2px;
  background-color: #007bff;
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.nav-link:hover::after {
  transform: scaleX(1);
}

/* Media query para pantallas grandes (escritorio) */
@media (min-width: 1024px) {
  .home-container {
    max-width: 80%;
    padding: 40px;
    height: 80vh; /* Ajustar la altura en pantallas grandes */
  }

  nav ul {
    gap: 50px;
  }

  h1 {
    font-size: 3rem;
  }
}

/* Media query para pantallas pequeñas (móviles) */
@media (max-width: 768px) {
  .home-container {
    padding: 10px;
    height: 85vh; /* Asegurar que el contenido esté dentro de la pantalla */
    text-align: center;
  }

  nav ul {
    flex-direction: column;
    gap: 15px;
  }

  h1 {
    font-size: 2rem; /* Ajustar el tamaño del título */
  }
}
</style>
