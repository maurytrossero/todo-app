<template>
      <!-- Incluir la barra de navegación -->
      <Navbar />
  <div class="register-container">
    <div class="register-box">
      <h1>Registrar</h1>
      <form @submit.prevent="register">
        <div class="input-group">
          <input type="text" v-model="name" placeholder="Nombre" required />
        </div>
        <div class="input-group">
          <input type="text" v-model="email" placeholder="Email" required />
        </div>
        <div class="input-group">
          <input type="password" v-model="password" placeholder="Contraseña" required />
        </div>
        <div class="input-group">
          <input type="password" v-model="password_confirmation" placeholder="Confirmar Contraseña" required />
        </div>
        <button type="submit">Registrar</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Navbar from "@/components/Navbar.vue"; // Importa el componente Navbar

export default {
  components: {
    Navbar, // Declara el componente
  },
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '', // Añadir este campo
    };
  },
  methods: {
    async register() {
      console.log("Password:", this.password);
      console.log("Confirm Password:", this.password_confirmation);
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation, // Enviar el campo de confirmación
        });
        console.log('Registro exitoso:', response.data);
        this.$router.push('/login'); // Redirigir al login después del registro
      } catch (error) {
        console.error('Error de registro:', error);
      }
    },
  },
};
</script>

<style scoped>

/* Estilos generales del contenedor */
.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 95%; /* Ajustar al 95% del ancho de la pantalla */
  margin: 0 auto; /* Centrar el contenedor en la pantalla */
  background: linear-gradient(135deg, #ffafbd, #ffc3a0); /* Fondo degradado */
}

/* Caja del formulario de registro */
.register-box {
  background-color: white;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 400px; /* Máximo ancho de la caja */
  width: 100%; /* Ancho total de la caja */
}

/* Título */
h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #333;
}

/* Agrupar los inputs */
.input-group {
  width: 100%; /* Asegurarse de que el grupo ocupe el 100% del ancho de la caja */
  display: flex; /* Usar flex para centrar */
  justify-content: center; /* Centrar el input horizontalmente */
}

/* Estilos de los inputs */
input {
  width: 90%; /* Ajustar el ancho al 90% para mantener márgenes */
  padding: 15px;
  margin: 0 0 20px; /* Margen inferior */
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background-color: #f7f7f7;
}

/* Cambiar el borde cuando se hace focus */
input:focus {
  border-color: #ff6f61;
  outline: none;
}

/* Botón de submit */
button {
  width: 90%; /* Ajustar el ancho al 90% para mantener márgenes */
  padding: 15px;
  background-color: #ff6f61;
  color: white;
  font-size: 1.2rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin: 0 auto; /* Centrar el botón horizontalmente */
}

/* Efecto hover en el botón */
button:hover {
  background-color: #ff5a45;
}

/* Diseño responsive para pantallas pequeñas */
@media (max-width: 600px) {
  h1 {
    font-size: 2rem;
  }

  .register-box {
    padding: 20px;
  }

  input,
  button {
    font-size: 1rem;
    padding: 10px;
  }
}
</style>
