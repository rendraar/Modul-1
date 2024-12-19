<template>
  <div class="admin-container-anime">
    <Notification ref="notification"/>
    <h1>Manage Anime</h1>

    <!-- Form Tambah Anime Baru -->
    <div class="form-container">
      <form @submit.prevent="handleSubmit" class="anime-form">
        <div class="form-row">
          <input type="text" v-model="form.anime_name" placeholder="Anime Name" required />
        </div>
        <div class="form-row">
          <select v-model="form.type" required>
            <option value="ongoing">Ongoing</option>
            <option value="complete">Complete</option>
            <option value="movie">Movie</option>
          </select>
        </div>
        <div class="form-row">
          <input type="text" v-model="form.image_url" placeholder="Image URL" required />
        </div>
        <div class="form-row">
          <input type="text" v-model="form.slug" placeholder="Slug" maxlength="50" required />
        </div>
        <div class="form-row">
          <input type="number" v-model="form.genre_id" min="1" placeholder="Genre ID" required />
        </div>
        <div class="form-row">
          <select v-model="form.status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
        <div class="form-row description-row">
          <textarea v-model="form.description" placeholder="Description" required></textarea>
        </div>
        <div class="form-row button-row">
          <button type="submit">Add</button>
          <button type="button" @click="resetForm">Clear Form</button>
        </div>
      </form>
    </div>

    <!-- Daftar Data Anime -->
    <div class="table-container">
      <table v-if="filteredAnime.length > 0">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Status</th>
            <th>Image URL</th>
            <th>Slug</th>
            <th>Genre ID</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in filteredAnime" :key="item.id || index">
            <td>{{ item.id || 'No ID' }}</td>
            <td>
              <input v-if="editingIndex === index" v-model="editingData.anime_name" />
              <span v-else>{{ item.anime_name }}</span>
            </td>
            <td>
              <select v-if="editingIndex === index" v-model="editingData.type">
                <option value="ongoing">Ongoing</option>
                <option value="complete">Complete</option>
                <option value="movie">Movie</option>
              </select>
              <span v-else>{{ item.type }}</span>
            </td>
            <td>
              <select v-if="editingIndex === index" v-model="editingData.status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <span v-else>{{ item.status }}</span>
            </td>
            <td>
              <input v-if="editingIndex === index" v-model="editingData.image_url" />
              <span v-else>{{ item.image_url }}</span>
            </td>
            <td>
              <input v-if="editingIndex === index" v-model="editingData.slug" />
              <span v-else>{{ item.slug }}</span>
            </td>
            <td>
              <input v-if="editingIndex === index" type="number" v-model="editingData.genre_id" />
              <span v-else>{{ item.genre_id }}</span>
            </td>
            <td>
              <textarea v-if="editingIndex === index" v-model="editingData.description"></textarea>
              <span v-else>{{ item.description }}</span>
            </td>
            <td>
              <button v-if="editingIndex !== index" @click="startEditing(index, item)">Edit</button>
              <button v-else @click="saveEdit(item.id)">Save</button>
              <button v-if="editingIndex === index" @click="cancelEdit">Cancel</button>
              <button v-if="editingIndex !== index" @click="deleteAnime(item.id)" class="delete-btn">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else>No data available</p>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import Notification from '@/components/Notification.vue';
  
  export default {
    components: { Notification },
  
    data() {
      return {
        anime: [],
        filteredAnime: [],
        form: {
          anime_name: '',
          type: 'ongoing',
          status: 'active',
          image_url: '',
          slug: '',
          description: '',
          genre_id: null
        },
        searchQuery: '',
        editingIndex: null, // Indeks baris yang sedang diedit
        editingData: {}, // Data sementara untuk diedit
        isEditing: false, // Menyatakan apakah dalam mode edit
      };
    },
    
    watch: {
      searchQuery(newQuery) {
        this.onSearch(newQuery);
      }
    },
  
    methods: {
      async fetchAnimes() {
        try {
          const response = await axios.get('http://localhost:8000/api/anime');
          this.anime = response.data;
          this.filteredAnime = this.anime;
        } catch (error) {
          this.$refs.notification.addNotification('Failed to load anime data.', 'error');
        }
      },

      handleSubmit() {
        if (!this.form.anime_name || !this.form.type || !this.form.image_url || !this.form.slug || !this.form.description || !this.form.genre_id) {
          this.$refs.notification.addNotification('Please fill all required fields.', 'warning');
          return;
        }
        if (this.isEditing) {
          this.saveEdit(this.form.id); // Simpan perubahan jika dalam mode edit
        } else {
          this.addNewAnime();
        }
      },

      async addNewAnime() {
        try {
          const response = await axios.post('http://localhost:8000/api/anime', this.form);
          await this.fetchAnimes();
          this.resetForm();
          this.$refs.notification.addNotification('Anime added successfully!', 'success');
        } catch (error) {
          this.$refs.notification.addNotification('Error adding anime. Please try again.', 'error');
        }
      },

      onSearch(query) {
        if (query.trim() !== "") {
          this.filteredAnime = this.anime.filter(anime =>
            anime.anime_name.toLowerCase().includes(query.toLowerCase()) || 
            anime.description.toLowerCase().includes(query.toLowerCase())
          );

          if (this.filteredAnime.length === 0) {
            this.$refs.notification.addNotification('No matching anime found.', 'warning');
          }
        } else {
          this.filteredAnime = this.anime;
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

          this.anime[this.editingIndex] = { ...this.editingData };
          this.cancelEdit();
          this.$refs.notification.addNotification('Anime updated successfully!', 'success');
        } catch (error) {
          console.log(error);
          this.$refs.notification.addNotification('Error updating anime. Please try again.', 'error');
        }
      },

      async deleteAnime(id) {
        try {
          await axios.delete(`http://localhost:8000/api/anime/${id}`);
          this.anime = this.anime.filter(a => a.id !== id);
          this.$refs.notification.addNotification('Anime deleted successfully!', 'success');
          this.onSearch(this.searchQuery);  // Memanggil pencarian kembali untuk memperbarui daftar
        } catch (error) {
          this.$refs.notification.addNotification('Error deleting anime. Please try again.', 'error');
        }
      },

      resetForm() {
        this.form = {
          anime_name: '',
          type: 'ongoing',
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

<style src="@/assets/css/AdminAnimeStyle.css"></style>