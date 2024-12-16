<template>
  <div class="admin-container">
    <!-- Konten di AdminView -->
    <div v-if="isAdminPage">
      <h1>Welcome to the admin dashboard!</h1>
      <div class="admin-navigation">
        <router-link to="/admin/anime">
          <button class="admin-button">Manage Anime</button>
        </router-link>
        <router-link to="/admin/genre">
          <button class="admin-button">Manage Genre</button>
        </router-link>
      </div>
    </div>
    <router-view />
  </div>
</template>

<script>
export default {
  computed: {
    // Menentukan apakah berada di /admin (bukan di /admin/anime atau /admin/genre)
    isAdminPage() {
      return this.$route.path === '/admin';
    },
  },
};
</script>

<style>
  button {
    cursor: pointer;
  }
  .admin-container {
    margin: 0 20px 0 20px;
    justify-items: center;
  }
  .admin-navigation {
    justify-self: center;
  }
  .admin-button {
    padding: 30px;
    border: none;
    font-size: 20px;
    background-color: black; /* Latar belakang tombol hitam */
    color: transparent; /* Warna teks transparan */
    background-image: linear-gradient(to left, #A1A1FF, #EBEBFF); /* Gradasi untuk teks */
    -webkit-background-clip: text; /* Klip gradasi hanya pada teks */
    -webkit-text-fill-color: transparent; /* Membuat teks transparan agar gradasi terlihat */
    transition: all 0.3s ease;
  }
  .admin-button:hover {
    transform: scale(1.05);
  }
</style>
