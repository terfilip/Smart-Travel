
var loadContent = function() {
  console.log("");
};

function getCountries() {

  $.ajax({
    type: "POST",
    url: "./php/core.php",
    data: { 
      q: "getCountries"}
    })
    .done(function( data ) {
      console.log(data);
      $('#dep').html(data);
      getRegions();
  });

}

function getRegions() {

  $.ajax({
    type: "POST",
    url: "./php/core.php",
    data: { 
      q: "getRegions"}
    })
    .done(function( data ) {
      console.log(data);
      $('#des').append(data);
      visualFormatting();
  });

}

function visualFormatting() {
  $('#dep').niceselect();
  $('#des').niceselect();
  $('#time').niceselect();

  $('.placeholder-select').css('display', 'none');
  $('#dep').css('display', 'inline');
  $('#des').css('display', 'inline');  
  
}

$('document').ready(function(){

  $('.placeholder-select').niceselect();

  getCountries(); 

  
})

$('.search-submit').click(function() {
  $('.progress').fadeIn(150);
  setTimeout(function() {
    $('.progress').fadeOut(200);
    $('.search').fadeOut(200);
  }, 3000);
  

})
