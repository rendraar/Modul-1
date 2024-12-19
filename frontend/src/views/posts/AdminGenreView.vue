<template>
  <div class="admin-container">
    <h1>Manage Genre</h1>

    <!-- Notification Component -->
    <Notification ref="notification" />

    <!-- Form Tambah Genre Baru -->
    <form @submit.prevent="handleSubmit">
      <input type="text" v-model="form.name" placeholder="Genre Name" required />
      <button type="submit">Add</button>
    </form>

    <!-- Daftar Data Genre -->
    <table v-if="genre.length > 0">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in genre" :key="item.id || index">
          <td>{{ item.id || 'No ID' }}</td>

          <!-- Genre Name (editable) -->
          <td>
            <div v-if="editingIndex !== index">
              {{ item.name || 'Unnamed Genre' }}
            </div>
            <div v-else>
              <input
                type="text"
                v-model="editingData.name"
                placeholder="Genre Name"
                required
              />
            </div>
          </td>

          <!-- Actions -->
          <td>
            <button v-if="editingIndex !== index" @click="startEditing(index, item)">Edit</button>
            <button v-else @click="saveEdit(item.id)">Save</button>
            <button v-if="editingIndex === index" @click="cancelEdit">Cancel</button>
            <button v-if="editingIndex !== index" @click="deleteGenre(item.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <p v-else>No data available</p>
  </div>
</template>

<script>
import axios from 'axios';
import Notification from '../../components/Notification.vue';

export default {
  components: { Notification },

  data() {
    return {
      genre: [],
      form: {
        name: ''
      },
      editingIndex: null, // Indeks baris yang sedang diedit
      editingData: {}, // Data sementara untuk diedit
      isEditing: false, // Menyatakan apakah dalam mode edit
    };
  },

  methods: {
    async fetchGenres() {
      try {
        const response = await axios.get('http://localhost:8000/api/genre');
        this.genre = response.data;
      } catch (error) {
        this.$refs.notification.addNotification('Failed to load genre data.', 'error');
      }
    },

    handleSubmit() {
      if (this.isEditing) {
        this.saveEdit(this.editingData.id);
      } else {
        this.addNewGenre();
      }
    },

    async addNewGenre() {
      try {
        await axios.post('http://localhost:8000/api/genre', this.form);
        await this.fetchGenres(); // Ambil data baru
        this.resetForm();
        this.$refs.notification.addNotification('Genre added successfully!', 'success');
      } catch (error) {
        this.$refs.notification.addNotification('Error adding genre. Please try again.', 'error');
      }
    },

    startEditing(index, item) {
      this.isEditing = true;
      this.editingIndex = index;
      this.editingData = { ...item }; // Salin data untuk diedit
    },

    cancelEdit() {
      this.isEditing = false;
      this.editingIndex = null;
      this.editingData = {}; // Reset data editing
    },

    async saveEdit(id) {
      try {
        await axios.put(`http://localhost:8000/api/genre/${id}`, this.editingData);

        // Gantikan objek lama dengan data yang baru di dalam array genre
        this.genre[this.editingIndex] = { ...this.editingData };

        // Reset editing state
        this.cancelEdit();

        this.$refs.notification.addNotification('Genre updated successfully!', 'success');
      } catch (error) {
        this.$refs.notification.addNotification('Error updating genre. Please try again.', 'error');
      }
    },

    async deleteGenre(id) {
      try {
        await axios.delete(`http://localhost:8000/api/genre/${id}`);
        this.genre = this.genre.filter(g => g.id !== id);
        this.$refs.notification.addNotification('Genre deleted successfully!', 'success');
      } catch (error) {
        this.$refs.notification.addNotification('Error deleting genre. Please try again.', 'error');
      }
    },

    resetForm() {
      this.form = {
        name: ''
      };
      this.isEditing = false;
    }
  },

  created() {
    this.fetchGenres();
  },
};
</script>

<style>
table {
  width: 100%;
  border-collapse: collapse;
}
table th,
table td {
  border: 1px solid #ddd;
  padding: 8px;
}
form {
  margin-bottom: 20px;
}
</style>
