<template>
  <Navbar />
  <div class="notas-container">
    <h2>Notas</h2>

    <div v-if="!isAuthenticated" class="error">
      <strong>Usuario no autenticado.</strong> Por favor, <router-link to="/login">inicia sesión</router-link>.
    </div>

    <form @submit.prevent="submitNote" v-if="isAuthenticated">
      <div>
        <input v-model="noteForm.title" @input="validateField('title')" placeholder="Título" required />
        <span v-if="errors.title" class="error">{{ errors.title }}</span>
      </div>

      <div>
        <textarea v-model="noteForm.description" @input="validateField('description')" placeholder="Contenido" required></textarea>
        <span v-if="errors.description" class="error">{{ errors.description }}</span>
      </div>

      <!-- Menú desplegable para seleccionar tags -->
      <div>
        <label for="tags">Seleccionar Tags:</label>
        <select v-model="noteForm.tag_id" id="tags" required>
          <option v-for="tag in tags" :key="tag.id" :value="tag.id">{{ tag.name }}</option>
        </select>
      </div>

      <!-- Selector de fecha de vencimiento -->
      <div>
        <label for="due_date">Fecha de vencimiento:</label>
        <input type="date" v-model="noteForm.due_date" id="due_date" />
      </div>

      <button type="submit">{{ isEdit ? 'Actualizar' : 'Crear' }} Nota</button>

      <div v-if="errors.server" class="error">
        {{ errors.server }}
      </div>
    </form>

    <!-- Botones de ordenación -->
    <div v-if="isAuthenticated && notes.length" class="sort-buttons">
      <button @click="sortNotes('created_at')" :class="{ active: sortField === 'created_at' }">
        Ordenar por Fecha de Creación
      </button>
      <button @click="sortNotes('due_date')" :class="{ active: sortField === 'due_date' }">
        Ordenar por Fecha de Vencimiento
      </button>
    </div>

    <!-- Lista de notas -->
    <ul v-if="isAuthenticated && notes.length">
      <li v-for="note in sortedNotes" :key="note.id" class="note-item">
        <h3>{{ note.title }}</h3>
        <p>{{ note.description }}</p>
        <p>Fecha de creación: {{ new Date(note.created_at).toLocaleDateString() }}</p>
        <p>Fecha de vencimiento: {{ new Date(note.due_date).toLocaleDateString() }}</p>
        <p v-if="note.tag">Categoría: {{ note.tag.name }}</p>
        <p v-if="note.user">Usuario: {{ note.user.name }}</p>
        <button @click="editNote(note)" class="edit-btn">Editar</button>
        <button @click="deleteNote(note.id)" class="delete-btn">Eliminar</button>

      </li>
    </ul>

    <p v-else>No hay notas disponibles.</p>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "@/components/Navbar.vue";

export default {
  components: {
    Navbar,
  },
  data() {
    return {
      noteForm: {
        title: "",
        description: "",
        tag: "",
        due_date: "", // Añadir campo para fecha de vencimiento

      },
      errors: {
        title: null,
        description: null,
        server: null,
      },
      isEdit: false,
      currentNoteId: null,
      tags: [], 
      sortField: "created_at", // Campo por defecto para la ordenación

    };
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters.isAuthenticated;
    },
    token() {
      return this.$store.state.token;
    },
    notes() {
      const response = this.$store.getters.getNotes;
      return response?.data || []; 
    },
    sortedNotes() {
      return [...this.notes].sort((a, b) => {
        return new Date(a[this.sortField]) - new Date(b[this.sortField]);
      });
    }
  },
  created() {
    this.$store.dispatch('tryAutoLogin').then(() => {
      if (this.isAuthenticated) {
        this.fetchTags(); // Llama a la función para obtener tags
        this.$store.dispatch('fetchNotes');
      }
    });
  },
  methods: {
    async fetchTags() {
      try {
        const response = await axios.get("/api/tags", {
          headers: { Authorization: `Bearer ${this.token}` }, // Autenticación
        });
        this.tags = response.data; // Asigna los tags obtenidos a la propiedad tags
      } catch (error) {
        console.error("Error al obtener los tags", error);
        this.errors.server = "Error al cargar los tags.";
      }
    },

    validateField(field) {
      this.errors[field] = null;
      if (field === "title" && !this.noteForm.title) {
        this.errors.title = "El título es obligatorio.";
      } else if (field === "description" && !this.noteForm.description) {
        this.errors.description = "El contenido es obligatorio."; 
      }
    },

    isValidForm() {
      this.errors = { title: null, description: null, server: null }; 
      if (!this.noteForm.title) this.errors.title = "El título es obligatorio.";
      if (!this.noteForm.description) this.errors.description = "El contenido es obligatorio."; 
      return !this.errors.title && !this.errors.description;
    },

    async submitNote() {
      if (!this.token) {
        console.error("Usuario no autenticado");
        return;
      }

      if (!this.isValidForm()) return;

      try {
        const payload = { ...this.noteForm };
        if (!this.noteForm.due_date) {
          delete payload.due_date; // Si no hay fecha de vencimiento, no la incluimos en el payload
        }

        if (this.isEdit) {
          await axios.put(`/api/notes/${this.currentNoteId}`, this.noteForm, {
            headers: { Authorization: `Bearer ${this.token}` },
          });
        } else {
          await axios.post("/api/notes", this.noteForm, {
            headers: { Authorization: `Bearer ${this.token}` },
          });
        }

        this.resetForm();
        this.$store.dispatch('fetchNotes');
      } catch (error) {
        this.errors.server = error.response?.data?.message || "Error al guardar la nota.";
        console.error("Error al enviar la nota", error);
      }
    },

    editNote(note) {
      this.noteForm = { title: note.title, description: note.description, tag: note.tag };
      this.isEdit = true;
      this.currentNoteId = note.id;
    },

    async deleteNote(id) {
      if (!this.token) {
        console.error("Usuario no autenticado");
        return;
      }

      try {
        await axios.delete(`/api/notes/${id}`, {
          headers: { Authorization: `Bearer ${this.token}` },
        });
        this.$store.dispatch('fetchNotes');
      } catch (error) {
        console.error("Error al eliminar la nota", error);
      }
    },

    sortNotes(field) {
      this.sortField = field;
    },

    resetForm() {
      this.noteForm = { title: "", description: "", tag: "", due_date: ""  };
      this.isEdit = false;
      this.currentNoteId = null;
    },
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

* {
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background-color: #f4f7fc;
  margin: 0;
  padding: 0;
}

.notas-container {
  background-color: #ffffff;
  border-radius: 15px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  padding: 40px;
  width: 100%;
  max-width: 900px;
  margin: 40px auto;
  box-sizing: border-box;
  transition: transform 0.3s ease;
}

h2 {
  text-align: center;
  font-size: 28px;
  color: #34495e;
  font-weight: 600;
  margin-bottom: 30px;
}

form {
  margin-bottom: 30px;
}

input,
textarea,
select {
  width: 100%;
  padding: 14px;
  border: 1px solid #ddd;
  border-radius: 10px;
  font-size: 16px;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  transition: border-color 0.3s ease;
}

input:focus,
textarea:focus,
select:focus {
  border-color: #007BFF;
  background-color: #ffffff;
}

button {
  background-color: #3498db;
  color: white;
  padding: 14px 20px;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2980b9;
}

.sort-buttons {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.sort-buttons button {
  flex: 1;
  margin-right: 10px;
  padding: 12px;
}

.sort-buttons button:last-child {
  margin-right: 0;
}

.sort-buttons .active {
  background-color: #2ecc71;
}

ul {
  list-style: none;
  padding: 0;
}

.note-item {
  background-color: #f0f4f8;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  margin-bottom: 20px;
  transition: transform 0.3s ease;
}

.note-item:hover {
  transform: translateY(-8px);
}

.note-item h3 {
  margin-bottom: 12px;
  font-size: 20px;
  font-weight: 600;
  color: #2c3e50;
}

.note-item p {
  margin-bottom: 10px;
  font-size: 15px;
  color: #7f8c8d;
}

li button {
  background-color: #e74c3c;
  color: white;
  padding: 10px 12px;
  border-radius: 6px;
  border: none;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

li button:hover {
  background-color: #c0392b;
}

.error {
  color: #e74c3c;
  font-size: 14px;
}

/* Botones de editar y eliminar dentro del listado de notas */
.note-item button {
  padding: 12px 20px; /* Aumentar el tamaño de los botones */
  border-radius: 6px;
  font-size: 14px;
  font-family: 'Poppins', sans-serif;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.3s;
  margin-right: 10px; /* Añadir espacio entre los botones */
}

.note-item button.edit-btn {
  background-color: #3498db;
  color: #fff;
}

.note-item button.edit-btn:hover {
  background-color: #2980b9;
  transform: scale(1.05);
}

.note-item button.delete-btn {
  background-color: #e74c3c;
  color: #fff;
}

.note-item button.delete-btn:hover {
  background-color: #c0392b;
  transform: scale(1.05);
}

/* Otros estilos para mejorar la presentación de las notas */
.note-item h3 {
  margin-bottom: 10px;
  font-size: 20px;
  font-family: 'Poppins', sans-serif;
  color: #2c3e50;
}

.note-item p {
  margin-bottom: 8px;
  font-size: 16px;
  color: #7f8c8d;
  font-family: 'Poppins', sans-serif;
}

/* Separar los botones del contenido de las notas */
.note-item {
  margin-bottom: 15px; /* Espacio entre las notas */
}

</style>