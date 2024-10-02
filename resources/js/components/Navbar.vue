<template>
  <nav class="navbar">
    <div class="navbar-toggle" @click="toggleMenu">
      <span v-if="!isMenuOpen">☰</span>
      <span v-else>✖</span>
    </div>
    <ul class="navbar-links" v-if="isMenuOpen || !isMobile">
      <li><router-link to="/">Inicio</router-link></li>
      <li><router-link to="/notes">Notas</router-link></li>
      <li v-if="!isAuthenticated"><router-link to="/login">Iniciar sesión</router-link></li>
      <li v-if="!isAuthenticated"><router-link to="/register">Registrarse</router-link></li>
      <li v-if="isAuthenticated" @click="logout">Cerrar sesión</li>
      <li v-if="isAuthenticated" class="username">Hola, {{ userName }}</li>
    </ul>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      isMenuOpen: false,
    };
  },
  computed: {
    ...mapGetters(['isAuthenticated', 'getUser']),
    userName() {
      return this.getUser ? this.getUser.name : '';
    },
    isMobile() {
      return window.innerWidth <= 600;
    },
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    logout() {
      this.$store.dispatch('logout');
      this.isMenuOpen = false;
    },
  },
  mounted() {
    // Intenta iniciar sesión automáticamente al montar el componente
    this.$store.dispatch('tryAutoLogin').then(() => {
      console.log('Usuario recuperado:', this.getUser);
    }).catch((error) => {
      console.error('Error al recuperar el usuario:', error);
    });
  },


};
</script>

<style scoped>
/* Barra de navegación */
.navbar {
  background-color: #8f653f;
  color: #ffffff;
  padding: 15px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 70%;
  margin: 0 auto;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  font-family: 'Poppins', sans-serif;
}

/* Estilo de los enlaces */
.navbar-links {
  list-style: none;
  display: flex;
  gap: 20px;
}

.navbar-links li {
  position: relative;
}

.navbar-links a {
  color: #ffffff; /* Color del texto claro */
  text-decoration: none;
  padding: 8px 12px; /* Espaciado en los enlaces */
  border-radius: 5px; /* Bordes redondeados en los enlaces */
  transition: background-color 0.3s, color 0.3s; /* Transición suave */
}

.navbar-links a:hover {
  background-color: rgba(255, 255, 255, 0.2); /* Efecto hover más claro */
  color: #ffe0b2; /* Color de texto claro en hover */
}

.username {
  color: #ffe0b2; /* Color para el nombre de usuario */
  font-weight: bold; /* Puedes cambiar el estilo como prefieras */
}

.navbar-toggle {
  display: none; /* Ocultar por defecto */
  cursor: pointer;
  font-size: 24px; /* Tamaño del ícono */
}

/* Estilo del menú en vista móvil */
@media (max-width: 600px) {
  .navbar {
    justify-content: flex-end; /* Alinear a la derecha */
    width: 100%; /* Ancho completo en móvil */
  }

  .navbar-links {
    flex-direction: column; /* Colocar enlaces en vertical */
    position: absolute;
    top: 60px; /* Ajusta según la altura de la barra */
    right: 0; /* Alinear a la derecha */
    background-color: #7133c9; /* Color de fondo más atractivo (morado) */
    width: 100%; /* Ancho completo */
    padding: 10px 0; /* Espaciado interno */
    border-radius: 0 0 8px 8px; /* Bordes redondeados inferiores */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Sombra suave */
    display: none; /* Ocultar por defecto */
    z-index: 1; /* Asegurar que esté por encima de otros elementos */
  }

  .navbar-links li {
    padding: 10px 0; /* Espaciado de los enlaces */
    text-align: center;
  }

  .navbar-links a {
    color: #ffffff; /* Color del texto claro */
  }

  .navbar-toggle {
    display: block; /* Mostrar toggle en móvil */
  }

  .navbar-links[style*="display: block"] {
    display: flex; /* Mostrar menú desplegable */
  }
}
</style>
