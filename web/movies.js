$(document).ready(function(){


});

function findMovie() {
  $(".movie-posters").click(function(){
    var getMovieDetails = {
      type: 'get',
      url: 'http://www.omdbapi.com/?i={movie.omdb_id}&plot=full&r=json',
      dataType: 'json',
      success: function(data) {
        console.log("Pulled from API");
        console.log("data");
      },
      error: function(error) {
        console.log("Something did not happen as intended");
      }
    }
    $.ajax(getMovieDetails);
  });
};
