import axios from 'axios';
import $ from 'jquery';

$(document).ready(function () {
  //Desactiva cortar, copiar y pegar
  $(document).bind('cut copy paste', function (e) {
      e.preventDefault();        
  });

  //Desactiva click dret
  $(document).on("contextmenu",function(e){
      console.log(e)
      return false;
      });
});

export default {
  async getOpponentPokemonByID(array, id) {           
    await axios.post('api/getPokemonByID/'+id)     
    .then(response => {
            if (array.poke_op == id){
                array.oimage_path=response.data.image_path
            }
        return response.data})
  },

  async getUserPokemonByID(array, id) {           
      await axios.post('api/getPokemonByID/'+id)     
      .then(response => {
              if (array.poke_player == id){
                  array.uimage_path=response.data.image_path    
          }
          return response.data})
  },


}









