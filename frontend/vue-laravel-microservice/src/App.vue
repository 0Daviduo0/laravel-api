<script >

import axios from 'axios';

//link const
const API_URL = 'http://localhost:8000/api/';
const API_VER = 'v1/';
const API = API_URL + API_VER;

//reset form
const FORM_CLEANER = {
  tags_id: []
};

export default {

  data() {
    
    return {

      movies: [],
      genres: [],
      tags: [],

      newMovie: { ...FORM_CLEANER },

      //form activation
      state: {
        enableForm: false
      }
    }
  },

  methods: {

    //submit movie
    Submit(e) {

      //prevent page refresh
      e.preventDefault();

      const newMovie = this.newMovie;
      const doesExist = API + ('id' in newMovie ? 'movie/update/' + this.newMovie.id : 'movie/store'); //if is an existent movie pass movie id to link

      // console.log(newMovie);
      // console.log(doesExist);

      //axios call
      axios.post(doesExist, newMovie).then(res => {

            const data = res.data;
            const success = data.success;

            if (success) {

              this.closeForm();
              this.Update();

            }
        }).catch(err => console.log);
    },
    
    //function to edit an existing movie
    Edit(movie) {

      //copy movie information to form
      this.newMovie = { ...movie };

      //get tags
      this.newMovie.tags_id = [];
      for (let i=0;i<movie.tags.length;i++) { //cicle tags
        const tag = movie.tags[i];
        this.newMovie.tags_id.push(tag.id);
      }

      //activate form
      this.state.enableForm = true;

    },

    //function to delete a movie
    Delete(movie) {

      //axios call
      axios.delete(API + 'movie/delete/' + movie.id).then(res => { 

        const data = res.data; //movie data
        const success = data.success; //operation state

        if (success) this.Update();

      }).catch(err => console.log); //get errors
    },

    closeForm() {

      this.newMovie = { ...FORM_CLEANER };
      this.state.enableForm = false;

    },

    //update movies data
    Update() {

      axios.get(API + 'movie/all').then(res => {

        const data = res.data;
        const success = data.success;
        const response = data.response;

        const movies = response.movies;
        const genres = response.genres;
        const tags = response.tags;

        if (success) {

          this.movies = movies;
          this.genres = genres;
          this.tags = tags;

        }
      }).catch(err => console.log);
    }
  },

  //action when page loads
  mounted() {

    this.Update();

  }

};

</script>

<template>
  <div class="allWrapper">

    <h1>LISTA FILM</h1>
    
    <div class="formContainer" v-if="state.enableForm"> <!-- se il form è true -->
    
      <form> 
        <label for="name">Titolo</label>
          <input type="text" name="name" v-model="newMovie.name"> <br>

        <label for="year">Anno</label>
          <input type="number" name="year" v-model="newMovie.year"> <br>

        <label for="cashOut">Incassi</label>
          <input type="number" name="cashOut" v-model="newMovie.cashOut"> <br>

        <label for="genre">Genere</label>
          <select name="genre_id" v-model="newMovie.genre_id">
            <option v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</option>
          </select> <br>
        
        <label>Etichette:</label>
          <div v-for="tag in tags" :key="tag.id">
            <input type="checkbox" :id="'tag-' + tag.id" :value="tag.id" v-model="newMovie.tags_id">
            <label :for="'tag-' + tag.id">{{ tag.name }}</label>
          </div>

        <!-- cancel button -->
        <button @click="closeForm">ANNULLA</button>
        <!-- submit/update button -->
        <input type="submit" @click="Submit" :value="'id' in newMovie ? 'AGGIORNA FILM: ' + newMovie.id : 'CREA NUOVO FILM'"> <!-- if id exist then modify button to edit -->
      </form>

    </div>


    <div v-else> <!-- se il form è false -->

      <button @click="state.enableForm = true">CREA UN NUOVO FILM</button>

      <div class="moviesWrapper">

        <div class="movieContainer" v-for="movie in movies" :key="movie.id">
            
            {{ movie.name }} <br>

            <button @click="Edit(movie)">MODIFICA</button>
            <button @click="Delete(movie)">CANCELLA</button>

            <ul>
              <li v-for="tag in movie.tags" :key="tag.id"> {{ tag.name }} </li>
            </ul>
            
        </div>
        
      </div>

    </div>

  </div>
</template>

<style scoped>

.allWrapper{
    width: 1280px;
    display: flex;
    flex-direction: column;
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


</style>
