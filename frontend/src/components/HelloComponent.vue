<template>
  <div>
    <h1>Practica API</h1>

    <!-- Menú desplegable para categorías -->
    <label for="category">Seleccione Categoría:</label>
    <select id="category" v-model="selectedCategory">
      <option value="hello">Storage</option>
      <option value="json">JSON</option>
      <option value="csv">CSV</option>
    </select>

    <!-- Botones de acción -->
    <div v-if="selectedCategory">
      <button @click="fetchAll">Mostrar archivos</button>
      <button @click="fetchById">Buscar por ID</button>
      <button @click="create">Crear</button>
      <button @click="update">Actualizar</button>
      <button @click="deleteItem">Eliminar</button>
    </div>

    <!-- Resultado de la API -->
    <div>
      <h2>Response:</h2>
      <pre>{{ response }}</pre>
    </div>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  data() {
    return {
      selectedCategory: '', // Almacena la categoría seleccionada
      response: null, // Almacena la respuesta de la API
    };
  },
  methods: {
    async fetchAll() {
      try {
        const res = await axios.get(`/${this.selectedCategory}`);
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    async fetchById() {
      const filename = prompt('Ingrese el nombre del archivo:');
      if (!filename) return;
      try {
        const res = await axios.get(`/${this.selectedCategory}/${filename}`);
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    async create() {
      const filename = prompt('Ingrese el nombre del archivo:');
      const content = prompt('Ingrese el contenido del archivo:');
      if (!filename || !content) return;
      try {
        const res = await axios.post(`/${this.selectedCategory}`, {
          filename,
          content,
        });
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    async update() {
      const filename = prompt('Ingrese el nombre del archivo a actualizar:');
      const content = prompt('Ingrese el nuevo contenido del archivo:');
      if (!filename || !content) return;
      try {
        const res = await axios.put(`/${this.selectedCategory}/${filename}`, {
          content,
        });
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    async deleteItem() {
      const filename = prompt('Ingrese el nombre del archivo a eliminar:');
      if (!filename) return;
      try {
        const res = await axios.delete(`/${this.selectedCategory}/${filename}`);
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
  },
};
</script>

<style scoped>
#category {
  margin-bottom: 10px;
}

button {
  margin: 5px;
}
</style>