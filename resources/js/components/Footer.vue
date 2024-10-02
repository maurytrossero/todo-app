<template>
    <footer class="footer-container">
      <div class="footer-content">
        <p class="copyright">© 2024 Aplicación desarrollada por Mauricio Trossero. Todos los derechos reservados.</p>
        <div class="footer-links">
          <a href="/privacy-policy">Política de Privacidad</a>
          <a href="/terms-of-service">Términos de Servicio</a>
          <a href="/contact">Contacto</a>
          <a href="/about">Acerca de</a>
        </div>
        <div class="social-media">
          <a href="https://www.facebook.com/mauricio.trossero/" target="_blank">Facebook</a>
          <a href="https://www.instagram.com/mauriciotrossero/" target="_blank">Instagram</a>
          <a href="https://www.linkedin.com/in/mauricio-trossero/" target="_blank">Linkedin</a>
        </div>
      </div>
    </footer>
  </template>
  
  <script>
  export default {
    name: 'Footer'
  }
  </script>
  
  <style scoped>
  .footer-container {
    background-color: #f8f9fa; /* Fondo claro */
    color: #333; /* Texto oscuro */
    text-align: center;
    padding: 40px 10px; /* Más espacio alrededor del pie de página */
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    margin-top: 40px; /* Separación con el contenido superior */
    width: 100%; /* Asegurar que ocupa todo el ancho */
    position: relative; /* Asegurar que esté en el flujo del documento */
    left: 0; /* Alinear a la izquierda */
    right: 0; /* Alinear a la derecha */
  }
  
  .footer-content {
    max-width: 1200px; /* Ancho máximo */
    margin: 0 auto; /* Centrando el contenido */
    padding: 20px;
    border-radius: 10px;
    background-color: #ffffff; /* Fondo blanco */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
  }
  
  .copyright {
    font-size: 0.9rem;
    margin: 10px 0;
    font-family: 'Poppins', sans-serif; /* Mantener la misma fuente */
  }
  
  .footer-links {
    margin: 10px 0;
  }
  
  .footer-links a {
    color: #007bff; /* Color azul para los enlaces */
    margin: 0 15px;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
  }
  
  .footer-links a:hover {
    color: #0056b3; /* Color más oscuro para el hover */
  }
  
  .social-media {
    margin-top: 10px;
  }
  
  .social-media a {
    color: #007bff; /* Color azul para los enlaces de redes sociales */
    margin: 0 10px;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
  }
  
  .social-media a:hover {
    color: #0056b3; /* Color más oscuro para el hover */
  }
  
  /* Media query para pantallas pequeñas */
  @media (max-width: 768px) {
    .footer-content {
      padding: 15px;
    }
  
    .footer-links a {
      margin: 0 8px; /* Reducir el margen en móviles */
    }
  
    .social-media a {
      margin: 0 5px; /* Reducir el margen en móviles */
    }
  }
  </style>
  