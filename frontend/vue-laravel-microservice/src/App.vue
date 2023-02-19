<script >

import axios from 'axios';

const API_URL = 'http://localhost:8000/api/v1/';

export default {

  data() {
    
    return {

      force_update: false,

      movies_bk: [],
      movies: [],
      genres: [],
      tags: [],

      movie_name: '',
      movie_year: '',
      movie_cashOut: '',

      movie_genre: '',
      movie_tags: [],

      createMovie_variable: false,
      updateMovie_variable: -1,
      
      test: true
    }
  },
  methods: {

    // function that set's a boolean value to activate/disable movie creation
    activateCreateMovie() {

      this.createMovie_variable = true;
    },
    disableCreateMovie() {

      this.createMovie_variable = false;
    },

    // function that set's a boolean value to activate/disable movie update
    activateUpdateMovie(id) {
      
      const movie = this.getMovieById(id);
      this.updateMovie_variable = id;

      for (let x=0;x<this.tags.length;x++) {

        const tag = this.tags[x];
        if (this.tagFinder(movie, tag)) {

          this.movie_tags.push(tag.id);
        }
      }
    },
    disableUpdateMovie() {

      this.updateMovie_variable = -1;
    },

    // function to ceate movies
    createMovie(e) {

      e.preventDefault();

      const movie = this.buildMovie();

      axios.post(API_URL + 'movie/store', movie)
        .then(res => {

          const data = res.data;
          const success = data.success;

          if (success) {

            this.clearForms();
            this.updateMovies();
          }
        }).catch(err => console.error(err));
    },

    // function to stop the creating movie process
    cancelCreateMovie(e) {

      e.preventDefault();
      this.clearForms();
    },

    // function to update a movie
    updateMovie(e) {

      e.preventDefault();

      const movie = this.getMovieById(this.updateMovie_variable);
      movie['tags_id'] = this.movie_tags;
      
      axios.post(API_URL + 'movie/update/' + this.updateMovie_variable, movie)
          .then(res => {

            const data = res.data;
            const success = data.success;

            if (success) {

              this.disableUpdateMovie();
              this.updateMovies();
            }
          }).catch(err => console.error(err));
    },

    // function to stop the updating movie process
    cancelUpdateMovie(e) {

      e.preventDefault();
      this.disableUpdateMovie();
    },

    // function to delete a movie
    deleteMovie(id) {

      axios.get(API_URL + 'movie/delete/' + id)
           .then(res => {

            const data = res.data;
            const success = data.success;
            
            if (success) {

              this.updateMovies();
            }
           })
           .catch(err => console.error(err));
    },

    // function to clear the forms (if not the forms remains with older text)
    clearForms() {

      this.movie_name = '';
      this.movie_year = '';
      this.movie_cashOut = '';
      this.movie_genre = '';
      this.movie_tags = [];

      this.disableCreateMovie();
    },
    
    // retrieve new movies list
    updateMovies() {

      axios.get(API_URL + 'movie/all')
         .then(res => {

            console.log(res);

            const data = res.data;
            const success = data.success;
            const response = data.response;

            const movies = this.movies_bk = response.movies;
            const genres = response.genres;
            const tags = response.tags;

            if (success) {

              this.movies = movies;
              this.genres = genres;
              this.tags = tags;
            }
         })
         .catch(err => console.error(err));
    },

    // function to retrieve tags associated to a movie
    tagFinder(movie, tag) {

      for (let x=0;x<movie.tags.length;x++) {

        const movieTag = movie.tags[x];
        
        if (movieTag.id == tag.id) {

          return true;
        }
      }

      return false;
    },

    // function that puts togheter all movie informations
    buildMovie() {

      return {

        'name': this.movie_name,
        'year': this.movie_year,
        'cashOut': this.movie_cashOut,
        'genre_id': this.movie_genre,
        'tags_id': this.movie_tags,
      };
    },

    // function that retrieve a movie by his id
    movieIdFinder(id) {

      for (let x=0;x<this.movies.length;x++) {

        const movie = this.movies[x];

        if (movie.id == id)
          return x;
      }

      return null;
    },
    getMovieById(id) {

      return this.movies[this.movieIdFinder(id)];
    }
  },
  mounted() {

    this.updateMovies();
  }
};

</script>

<template>
  <div class="allWrapper">
    <h1>LISTA FILM</h1>

    <!-- Form to create movies -->
    <div class="addNewMovies_Container">

      <form v-if="createMovie_variable">
        <label for="name"> <i class="fa-solid fa-ticket"></i> | TITOLO</label>
          <input type="text" name="name" v-model="movie_name"> <br>
        <label for="year"> <i class="fa-regular fa-calendar-check"></i> | ANNO</label>
          <input type="number" name="year" v-model="movie_year"> <br>
        <label for="cashOut"> <i class="fa-solid fa-money-bill-trend-up"></i> | INCASSI</label>
          <input type="number" name="cashOut" v-model="movie_cashOut">

        <div class="genreContainer propertiesContainers">

          <label class="basicLabel" for="genre_id"> <i class="fa-solid fa-list-ul"></i> | GENERE </label>

          <select name="genre_id" v-model="movie_genre">
            <!-- retrieve genre name -->
            <option v-for="genre in genres" :key="genre.id" :value="genre.id">
              {{ genre.name }}
            </option>
          </select> 

        </div>

        <div class="tagsContainer">

          <label class="basicLabel"> <i class="fa-solid fa-tags"></i> | ETICHETTE </label> <br>
          
          <!-- Tag container -->
          <div v-for="tag in tags" :key="tag.id">
            <!-- tags already associated are checked -->
            <input type="checkbox" @click="updateCheckbox" :value="tag.id" :id="tag.id" v-model="movie_tags">
              <label :for="tag.id"> {{ tag.name }} </label> <br>
          </div>

        </div>

        <!-- button to cancel the movie creation -->
        <button @click="cancelCreateMovie">ANNULLA</button>

        <!-- button to create a movie based on the form -->
        <input @click="createMovie" type="submit" value="CREATE NEW MOVIE">

      </form>

      <button v-else @click="activateCreateMovie">CREA UN NUOVO FILM</button>

    </div>
    
    <!-- LIST START -->
    <div class="moviesWrapper">
      <!-- retrieve movie list -->
      <div class="movieContainer" v-for="movie in movies" :key="movie.id">

        <div class="movieTitle"> <h2>{{ movie.name }}</h2> </div>

        <!-- options to interact -->
        <div class="actionButtons" v-if="updateMovie_variable != movie.id">
          <!-- modify movie -->
          <button @click="activateUpdateMovie(movie.id)"> <i class="fa-regular fa-pen-to-square"></i> </button>
          <!-- delete movie -->
          <button @click="deleteMovie(movie.id)"> <i class="fa-regular fa-trash-can"></i> </button> 
        </div>
        <!-- form to modify movie -->
        <form v-else>
            <label for="name"> <i class="fa-solid fa-ticket"></i> | TITOLO</label>
            <input type="text" name="name" v-model="movie.name">
            <br>
            <label for="year"> <i class="fa-regular fa-calendar-check"></i> | ANNO</label>
            <input type="number" name="year" v-model="movie.year">
            <br>
            <label for="cashOut"> <i class="fa-solid fa-money-bill-trend-up"></i> | INCASSI</label>
            <input type="number" name="cashOut" v-model="movie.cashOut">
            <br>

            <!-- GENRES -->
            <div class="genreContainer propertiesContainers">

              <label class="basicLabel" for="genre_id"> <i class="fa-solid fa-list-ul"></i> | GENERE </label>

              <select name="genre_id" v-model="movie.genre_id">
                <option v-for="genre in genres" :key="genre.id" :value="genre.id"> {{ genre.name }} </option>
              </select>
            </div>

            <!-- TAGS -->
            <div class="tagsContainer">

              <label class="basicLabel"> <i class="fa-solid fa-tags"></i> | ETICHETTE </label>

              <div class="tagsContainer" v-for="tag in tags" :key="tag.id">
                <input class="rightSpacing" @click="updateCheckbox" type="checkbox" :value="tag.id" :id="tag.id" :checked="tagFinder(movie, tag)" v-model="movie_tags">
                  <label :for="tag.id"> {{ tag.name }} </label> <br>
              </div>

            </div>
            

            <!-- UNDO - SAVE -->
            <div class="actionButtons">

              <button @click="cancelUpdateMovie"> Annulla </button>
              <input @click="updateMovie" type="submit" :value="'Aggiorna film: ' + movie.id">

            </div>
        </form>
      </div>

    </div>
  </div>
</template>

<style scoped>

  .allWrapper{
    width: 1280px;
  }

  .moviesWrapper{
    display: grid;
    margin-top: 20px;
    grid-template-columns: repeat(5, 2fr);
    grid-column-gap: 25px;
    grid-row-gap: 25px;
  }

  .movieContainer{
    width: 210px;
    padding: 0 5px;
    padding-bottom: 10px;
    border-radius: 15px;
    background-color: rgba(255, 255, 255, 0.185);
  }

  .movieTitle{
    width: 200px;
    text-align: center;
  }

  .basicLabel{
    font-weight: 700;
    font-size: 18px;
  }

  .actionButtons{
    display: flex;
    width: 200px;
    justify-content: center;
  }

  .propertiesContainers{
    margin-top: 20px;
  }

  .tagsContainer{
    width: 200px;
  }

  .rightSpacing{
    margin-right: 10px;
  }

</style>
