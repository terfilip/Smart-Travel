
var loadContent = function() {
  console.log("");
};

$('document').ready(function(){

  $.ajax({
    type: "POST",
    url: "/smarttravel/php/core.php",
    data: { 
      q: "getCountries"}
    })
    .done(function( data ) {
      console.log(data);
      $('.change[name=departure]').append(data);
  });

  $.ajax({
    type: "POST",
    url: "/smarttravel/php/core.php",
    data: { 
      q: "getRegions"}
    })
    .done(function( data ) {
      console.log(data);
      $('.change[name=destination]').append(data);
  });

  $('.change').niceselect();
})

$('.search-submit').click(function() {
  $('.progress').fadeIn(150);
  setTimeout(function() {
    $('.progress').fadeOut(200);
    $('.search').fadeOut(200);
  }, 3000);
  

})
