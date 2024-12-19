<template>
  <div class="container">
    <header>
      <!-- Gunakan router-link untuk navigasi -->
      <router-link to="/" class="logo">ngeview</router-link>
      
      <form v-if="$route.path !== '/admin'" class="search-bar" @submit.prevent="onSearch">
        <a @click.prevent="onSearch">
          <img src="/assets/web/search.png" alt="search" />
        </a>
        <input
          type="text"
          placeholder="Search"
          v-model="searchQuery"
          @input="onSearch"
        />
      </form>
      <nav>
        <router-link v-if="$route.path === '/'" to="/admin">Admin</router-link>
        <router-link v-if="$route.path === '/admin'" to="/">Home</router-link>
        <router-link v-if="$route.path === '/admin/anime' || $route.path === '/admin/genre'" to="/admin">Back</router-link>
      </nav>
    </header>

    <!-- Placeholder untuk routing -->
    <main>
      <router-view :search-query="searchQuery"></router-view>
    </main>

    <!-- Sembunyikan footer jika di halaman admin -->
    <footer>
      <div class="footer-container">
        <div class="footer-left">
          <ul>
            <li><a href="#">Terms</a></li>
            <li><a href="#">Privacy</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>
        <div class="footer-center">
          <div class="vertical-line"></div>
        </div>
        <div class="footer-right">
          <ul>
            <li><a href="#">Get the App</a></li>
            <li><a href="#">Payment Policy</a></li>
            <li><p>&copy; 2024 ngeview</p></li>
          </ul>
        </div>
        <div class="footer-logo">
          <router-link to="/" class="logo">ngeview</router-link>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      searchQuery: "",  // Define searchQuery here
    };
  },
  methods: {
    onSearch() {
      // Handle the search functionality here
      console.log("Searching for:", this.searchQuery);
    }
  }
};
</script>
