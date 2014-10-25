
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

  $.ajax({
    type: "POST",
    url: "./php/core.php",
    data: { 
      country: $('.top:eq(1)').text(),
      region: $('.top:eq(3)').text(),
      time: $('.top:eq(4)').text(),
      q: "getRankings"
    }
    })
    .done(function( data ) {
      $('.progress').fadeOut(200);
      $('.search').fadeOut(200);
      setTimeout(function() {
        getContentView(data);
      }, 200);
      
  });

})

function getContentView(data) {

  $('.content-view').fadeIn(200);
  $('#cardlist').html(data);
}
