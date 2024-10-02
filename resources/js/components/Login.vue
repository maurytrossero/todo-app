<template>
    <!-- Incluir la barra de navegación -->
    <Navbar />
  <div class="login-container">
    <div class="login-box">
      <h1>Iniciar Sesión</h1>
      <form @submit.prevent="login">
        <input type="text" v-model="email" placeholder="Email" required />
        <input type="password" v-model="password" placeholder="Contraseña" required />
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapMutations } from 'vuex';
import Navbar from "@/components/Navbar.vue"; // Importa el componente Navbar


export default {
  components: {
    Navbar, // Declara el componente
  },
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    ...mapMutations(['setUser']),
    async login() {
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password,
        });

        console.log('Inicio de sesión exitoso:', response.data.message);

        // Guardar el token en localStorage
        localStorage.setItem('token', response.data.token);

        // Guardar el usuario en Vuex y redirigir
        this.setUser(response.data.user);
        this.$router.push('/notes'); // Redirige a la página de notas después de iniciar sesión
      } catch (error) {
        if (error.response && error.response.status === 401) {
          console.error('Error de autenticación:', error.response.data.message);
        } else {
          console.error('Error en la solicitud:', error);
        }
      }
    },
  },
};
</script>

<style scoped>
body {
  margin: 0; /* Asegúrate de que no haya margen por defecto en el body */
  padding: 0; /* Asegúrate de que no haya padding por defecto en el body */
  box-sizing: border-box; /* Asegura que el padding se incluya en el ancho total */
}

* {
  box-sizing: inherit; /* Aplicar box-sizing a todos los elementos */
}

/* Contenedor principal del login, ocupando casi todo el ancho de la pantalla */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 95vw; /* Ocupar casi todo el ancho de la pantalla */
  height: 100vh; /* Ocupar toda la altura de la pantalla */
  background: linear-gradient(135deg, #6dd5ed, #2193b0); /* Fondo degradado */
  padding: 20px;
  box-sizing: border-box; /* Asegurar que el padding se incluya en el ancho total */
  margin: 0 auto; /* Centrar el contenedor horizontalmente */
}

/* Caja de login, centrada y con un ancho limitado */
.login-box {
  background-color: white;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 500px; /* Ancho máximo de la caja de login */
  width: 100%; /* Ancho completo dentro del contenedor limitado */
}

/* Título */
h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #333;
}

/* Estilos de los inputs */
input {
  width: 100%;
  max-width: 400px; /* Máximo ancho de los inputs para evitar que se salgan */
  padding: 15px;
  margin: 0 auto 20px; /* Margen inferior y centrado horizontal */
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background-color: #f7f7f7;
  display: block; /* Asegura que los inputs se comporten como bloques */
}


/* Focus en los inputs */
input:focus {
  border-color: #2193b0;
  outline: none;
}

/* Botón de login */
button {
  width: 100%;
  max-width: 400px; /* Máximo ancho del botón para evitar que se salga */
  padding: 15px;
  background-color: #2193b0;
  color: white;
  font-size: 1.2rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin: 0 auto; /* Centrar el botón horizontalmente */
}

/* Hover del botón */
button:hover {
  background-color: #186f84;
}

/* Diseño responsive para pantallas pequeñas */
@media (max-width: 768px) {
  .login-container {
    width: 90vw; /* Ocupar un poco menos del ancho de la pantalla en móviles */
  }

  .login-box {
    padding: 20px; /* Reducir el padding para evitar exceso en pantallas pequeñas */
  }

  h1 {
    font-size: 2rem; /* Ajustar el tamaño del título */
  }

  input, button {
    font-size: 1rem; /* Reducir un poco el tamaño de los inputs y botón */
    padding: 10px; /* Menos padding en pantallas pequeñas */
  }
}

/* Ampliar la caja de login en pantallas más grandes */
@media (min-width: 1024px) {
  .login-box {
    padding: 50px; /* Aumentar el padding */
    max-width: 600px; /* Aumentar el ancho máximo en pantallas más grandes */
  }

  h1 {
    font-size: 3rem; /* Aumentar el tamaño del título */
  }

  input, button {
    font-size: 1.2rem; /* Ajustar el tamaño de los inputs y botones */
    padding: 15px; /* Ampliar el padding */
  }
}
</style>
