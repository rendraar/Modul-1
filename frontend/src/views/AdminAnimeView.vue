<template>
    <div class="admin-container">
      <h1>Manage Anime</h1>
  
      <!-- Notification Component -->
      <Notification ref="notification" />
  
      <!-- Form Tambah Anime Baru -->
      <form @submit.prevent="handleSubmit">
        <input type="text" v-model="form.anime_name" placeholder="Anime Name" required />
        <input type="text" v-model="form.type" placeholder="Type (ongoing, complete, movie)" required />
        <input type="text" v-model="form.image_url" placeholder="Image URL" required />
        <input type="text" v-model="form.slug" placeholder="Slug" required />
        <textarea v-model="form.description" placeholder="Description" required></textarea>
        <input type="number" v-model="form.genre_id" placeholder="Genre ID" required />

        <!-- Dropdown for Status -->
        <select v-model="form.status" required>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>

        <button type="submit">Add</button>
      </form>
  
      <!-- Daftar Data Anime -->
      <table v-if="anime.length > 0">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in anime" :key="item.id || index">
            <td>{{ item.id || 'No ID' }}</td>
            
            <!-- Anime Name (editable) -->
            <td>
              <div v-if="editingIndex !== index">
                {{ item.anime_name || 'Unnamed Anime' }}
              </div>
              <div v-else>
                <input
                  type="text"
                  v-model="editingData.anime_name"
                  placeholder="Anime Name"
                  required
                />
              </div>
            </td>
  
            <!-- Anime Type (editable) -->
            <td>
              <div v-if="editingIndex !== index">
                {{ item.type || 'Unknown Type' }}
              </div>
              <div v-else>
                <input
                  type="text"
                  v-model="editingData.type"
                  placeholder="Type"
                  required
                />
              </div>
            </td>
  
            <!-- Actions -->
            <td>
              <button v-if="editingIndex !== index" @click="startEditing(index, item)">Edit</button>
              <button v-else @click="saveEdit(item.id)">Save</button>
              <button v-if="editingIndex === index" @click="cancelEdit">Cancel</button>
              <button v-if="editingIndex !== index" @click="deleteAnime(item.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else>No data available</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Notification from '../components/Notification.vue';
  
  export default {
    components: { Notification },
  
    data() {
      return {
        anime: [],
        form: {
          anime_name: '',
          type: '',
          status: 'active',
          image_url: '',
          slug: '',
          description: '',
          genre_id: null
        },
        editingIndex: null, // Indeks baris yang sedang diedit
        editingData: {}, // Data sementara untuk diedit
        isEditing: false, // Menyatakan apakah dalam mode edit
      };
    },
  
    methods: {
      async fetchAnimes() {
        try {
          const response = await axios.get('http://localhost:8000/api/anime');
          this.anime = response.data;
        } catch (error) {
          this.$refs.notification.addNotification('Failed to load anime data.');
        }
      },
  
      handleSubmit() {
        if (!this.form.anime_name || !this.form.type || !this.form.image_url || !this.form.slug || !this.form.description || !this.form.genre_id) {
          this.$refs.notification.addNotification('Please fill all required fields.');
          return;
        }
        this.addNewAnime();
      },
  
      async addNewAnime() {
        try {
          const response = await axios.post('http://localhost:8000/api/anime', this.form);
          console.log(response.data);  // Gunakan response yang sudah didefinisikan
          await this.fetchAnimes(); // Ambil data baru
          this.resetForm();
          this.$refs.notification.addNotification('Anime added successfully!');
        } catch (error) {
          console.error(error);
          this.$refs.notification.addNotification('Error adding anime. Please try again.');
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
          const response = await axios.put(`http://localhost:8000/api/anime/${id}`, this.editingData);
  
          // Gantikan objek lama dengan data yang baru di dalam array anime
          this.anime[this.editingIndex] = { ...this.editingData };  // Ini cara yang lebih reaktif
  
          // Reset editing state
          this.cancelEdit();
  
          this.$refs.notification.addNotification('Anime updated successfully!');
        } catch (error) {
          console.log(error);
          this.$refs.notification.addNotification('Error updating anime. Please try again.');
        }
      },
  
      async deleteAnime(id) {
        try {
          await axios.delete(`http://localhost:8000/api/anime/${id}`);
          this.anime = this.anime.filter(a => a.id !== id);
          this.$refs.notification.addNotification('Anime deleted successfully!');
        } catch (error) {
          this.$refs.notification.addNotification('Error deleting anime. Please try again.');
        }
      },
  
      resetForm() {
        this.form = {
          anime_name: '',
          type: '',
          image_url: '',
          status: 'active',
          slug: '',
          description: '',
          genre_id: null
        };
        this.isEditing = false;
        this.editingIndex = null;
        this.editingData = {};
      }
    },
  
    created() {
      this.fetchAnimes();
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
  