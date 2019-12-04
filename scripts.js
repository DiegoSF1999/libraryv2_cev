document.querySelector('#send').addEventListener('click', function() {
  

        $.get("http://localhost/Diego/library/public/index.php/api/prueba", function(data, status){
          alert("conseguido");
        });


});



function register() {
    alert('funciona bien');
}

$.ajax({
    method: "POST",
    url: "http://localhost/Diego/library/public/index.php/api",
    data: { name: "John", location: "Boston" }
  })
    .done(function( msg ) {
      alert( "Data Saved: " + msg );
    });

$( document ).ready(function() {
        var api_url = 'https://api.linkpreview.net'
        var key = '5b578yg9yvi8sogirbvegoiufg9v9g579gviuiub8' // not real
});
