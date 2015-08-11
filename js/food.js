// for the ajax for the plates table
$(function(){
  $(document.body).ready(formAjax(event, 'plateView', 'food.ajax.handler.php'));
  $(document.body).ready(formAjax(event, 'dishView', 'food.ajax.handler.php'));
});
