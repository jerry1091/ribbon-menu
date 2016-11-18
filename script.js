(function($){
$(document).ready(function(){

$("#cssmenu").menumaker({
  title: "Menu",
  breakpoint: 768,
  format: "multitoggle"
});

$("#cssmenu a").each(function() {
  var linkTitle = $(this).text();
  $(this).attr('data-title', linkTitle);
});

});
})(jQuery);
