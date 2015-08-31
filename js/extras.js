//for the ajax for the drinks tables
//$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
//    options.async = true;
//});
$(function(){
  //$(document.body).ready(formAjax(event, 'brewsView', 'extras.ajax.handler.php'));
  $(document.body).ready(formAjax(event, 'wineView', 'extras.ajax.handler.php'));
  $(document.body).ready(formAjax(event, 'sizeView', 'extras.ajax.handler.php'));
});