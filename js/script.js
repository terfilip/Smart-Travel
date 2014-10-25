
var loadContent = function() {
  console.log("");
};

$('document').ready(function(){

  $.ajax({
    type: 'GET',
    url: "/php/core.php",
    data: {
      q:"getCountries"
    }, 
    success: function(data) {
      $('.change[name=departure]').append(data);
    }
  });
  $.ajax({
    type: 'GET',
    url: "/php/core.php",
    data: {
      q:"getRegions"
    }, 
    success: function(data) {
      $('.change[name=destination]').append(data);
    }
  });


  lol = '<option value="GBP">GBP</option><option value="NOK">NOK</option><option value="USD">USD</option>';
  $('.change[name=departure]').append(lol);

  $('.change').niceselect();
})

$('.search-submit').click(function() {
  $('.progress').fadeIn(150);

  $('.progress').fadeOut(200);
  $('.search').fadeOut(200);

})
