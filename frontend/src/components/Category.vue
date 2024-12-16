<!-- File: src/components/Category.vue -->
<template>
    <section class="category">
      <h2>{{ title }}</h2>
      <div class="scroll-container">
        <div v-for="item in items" :key="item.id" class="item">
          <a :href="item.slug ? `/${item.slug}` : '#'">
            <img :src="`/assets/images/${item.image_url || 'default.png'}`" :alt="item.anime_name" />
          </a>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    props: {
      title: String,
      items: Array,
    },
  };
</script>
  
<style scoped>
  /* Styles specific to the Category component */
    .category {
        margin-bottom: 30px;
    }

    .category h2 {
        color: #fff;
        font-size: 24px;
        margin-bottom: 10px;
        padding-left: 20px;
        text-shadow: 
            1px 1px 0 #8888D0,  /* Bayangan ke kanan bawah */
            -1px 1px 0 #8888D0, /* Bayangan ke kiri bawah */
            2px -1px 0 #8888D0, /* Bayangan ke kanan atas */
            0 0 0 #8888D0; /* Bayangan ke kiri atas */
        font-weight: bold;
    }
    .scroll-container {
        display: flex;
        overflow-x: auto; /* Mengaktifkan scroll horizontal */
        padding: 20px 20px;
        gap: 15px;
        scrollbar-color: #5c5c91 #333; /* Warna scrollbar (opsional) */
        scrollbar-width: auto; /* Pastikan scrollbar selalu muncul */
    }

    /* Mengatur tampilan scrollbar untuk Chrome, Edge, Safari */
    .scroll-container::-webkit-scrollbar {
        height: 8px; /* Tinggi scrollbar */
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background: #8888D0; /* Warna dari 'thumb' scrollbar */
        border-radius: 10px;
    }

    .scroll-container::-webkit-scrollbar-track {
        background: #333; /* Warna track scrollbar */
    }

    .item {
        min-width: 200px; /* Lebar minimum untuk setiap item */
        height: 300px;
        background-color: #333;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        border-radius: 10px;
        transition: transform 0.3s ease; 
        box-shadow: 0 0 9px rgba(161, 161, 255, 0.5);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    }

    .item:hover {
        transform: scale(1.05); /* Efek zoom saat item di-hover */
        box-shadow: 0 0 15px rgba(161, 161, 255, 0.7);
    }

    .item a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .item a img {
        width: 100%;  /* Mengisi penuh lebar item */
        height: 100%; /* Mengisi penuh tinggi item */
        object-fit: cover;  /* Memastikan gambar tidak terdistorsi */
        border-radius: 10px;  /* Mengikuti bentuk container */
        color: #fff;
    }
</style>
  