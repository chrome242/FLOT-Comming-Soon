// for the ajax for the drinks tables
$(function(){
  $(document.body).ready(formAjax(event, 'beerManagement', 'drinks.ajax.handler.php'));
  $(document.body).ready(formAjax(event, 'wineManagement', 'drinks.ajax.handler.php'));
  $(document.body).ready(formAjax(event, 'breweryManagement', 'drinks.ajax.handler.php'));
  $(document.body).ready(formAjax(event, 'wineryManagement', 'drinks.ajax.handler.php'));

});