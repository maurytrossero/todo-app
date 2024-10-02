import { createStore } from 'vuex';
import axios from 'axios';

export default createStore({
  state: {
    notes: [], // Almacena las notas
    user: null, // Almacena los datos del usuario
    token: localStorage.getItem('token') || null, // Cargar el token desde localStorage
  },
  mutations: {
    setNotes(state, notes) {
      state.notes = notes; // Establecer las notas en el estado
    },
    setUser(state, user) {
      state.user = user; // Establecer el usuario en el estado
    },
    setToken(state, token) {
      state.token = token;
      localStorage.setItem('token', token); // Guardar el token en localStorage
    },
    clearAuthData(state) {
      state.token = null; // Limpiar el token
      state.user = null; // Limpiar el usuario
      localStorage.removeItem('token'); // Eliminar el token de localStorage
    }
  },
  actions: {
    async fetchNotes({ commit, state }) {
      if (state.token) { // Verificamos si hay un token
        try {
          const response = await axios.get('/api/notes', {
            headers: {
              Authorization: `Bearer ${state.token}`, // Enviar el token en la cabecera
            },
          });
          commit('setNotes', response.data); // Actualizar las notas en el estado
        } catch (error) {
          console.error('Error al obtener notas:', error.response?.data?.message || error.message);
        }
      } else {
        console.log('No hay token de autenticación');
      }
    },
    async login({ commit }, authData) {
      try {
        const response = await axios.post('/api/login', {
          email: authData.email,
          password: authData.password,
        });

        commit('setToken', response.data.token); // Guardar el token
        commit('setUser', response.data.user); // Guardar los datos del usuario
        console.log('Usuario:', response.data.user);

      } catch (error) {
        console.error('Error de autenticación:', error.response?.data?.message || error.message);
      }
    },
    logout({ commit }) {
      commit('clearAuthData'); // Limpiar los datos de autenticación al cerrar sesión
    },
    // Ejemplo en tryAutoLogin
    async tryAutoLogin({ commit }) {
      const token = localStorage.getItem('token');
      if (!token) {
        console.log('No hay token'); // Mensaje si no hay token
        return;
      }
      try {
        console.log('Intentando autenticación automática con token:', token);
        const response = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        console.log('Datos de usuario recuperados:', response.data); // Mensaje con los datos recuperados
        commit('setUser', response.data);
        commit('setToken', token);
      } catch (error) {
        console.error('Error al intentar autenticación automática:', error.response?.data?.message || error.message);
        commit('clearAuthData');
      }
    },
  },
  getters: {
    isAuthenticated(state) {
      return !!state.token; // Devuelve si el usuario está autenticado
    },
    getUser(state) {
      return state.user; // Devuelve los datos del usuario
    },
    getNotes(state) {
      return state.notes; // Devuelve las notas
    },
  },
});
