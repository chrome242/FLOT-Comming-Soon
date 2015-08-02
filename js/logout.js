
$("#Logout").click(function(){
  var oldLoc = location;
  location = oldLoc + "?Logout=true";
});