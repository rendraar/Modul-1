<template>
    <div>
      <Category title="Recently View" :items="categories.recently" />
      <Category title="On Going" :items="categories.ongoing" />
      <Category title="Complete" :items="categories.complete" />
      <Category title="Movie" :items="categories.movie" />
    </div>
  </template>
  
  <script>
  import Category from '../components/Category.vue';
  
  export default {
    components: {
      Category,
    },
    data() {
      return {
        categories: {
          recently: [],
          ongoing: [],
          complete: [],
          movie: [],
        },
      };
    },
    mounted() {
      fetch('http://localhost:8000/api/anime')
        .then((response) => response.json())
        .then((data) => {
          const groupedData = this.groupDataByType(data);
          this.categories = groupedData;
        })
        .catch((error) => console.error('Error fetching data:', error));
    },
    methods: {
      groupDataByType(data) {
        return data.reduce(
          (acc, item) => {
            if (!acc[item.type]) acc[item.type] = [];
            acc[item.type].push(item);
            return acc;
          },
          { recently: [], ongoing: [], complete: [], movie: [] }
        );
      },
    },
  };
  </script>
  