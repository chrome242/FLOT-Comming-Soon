// for the ajax for the groups table
$(function(){
  $(document.body).ready(formAjax(event, 'userGroups', 'users.ajax.handler.php'));
  //$(document.body).ready(formAjax(event, 'memberEdit', 'users.ajax.handler.php'));
  $('#targetModal').on('show.bs.modal', modalAjax(event, "targetModal", "users.ajax.handler.php"));
});

// for the dummy button
$("#Logout").click(function(){
  var oldLoc = location;
  location = oldLoc + "?Logout=true";
});
