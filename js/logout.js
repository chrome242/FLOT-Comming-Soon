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

// for password matching
$("#targetModal").on("blur", "#password, #verify", function(){
  
  // one of the two has been selected, get both values.
  var pass = $("#password").val();
  var ver = $("#verify").val();
  
  // if both are set, then neither should equal ""
  if (ver != "" && pass !="") {
    
    // if they both match:
    if (ver === pass) {
      // test if the rest of the critera are met:
      var num = /(?=.*\d)/;
      var low = /(?=.*[a-z])/;
      var upp = /(?=.*[A-Z])/;
      var minlen = 6;
      var pass_all = true; // will flip false if any of the above are true
      
      // fails having a number
      if (!num.test(pass)) {
        pass_all = false;
        $("#num").addClass("fail-modal");
      } else {
        $("#num").removeClass("fail-modal");
      }
      
      // fails having a lower case
      if (!low.test(pass)) {
        pass_all = false;
        $("#lcase").addClass("fail-modal");
      } else {
        $("#lcase").removeClass("fail-modal");
      }
      
      // fails having an uppercase
      if (!upp.test(pass)) {
        pass_all = false;
        $("#ucase").addClass("fail-modal");
      } else {
        $("#ucase").removeClass("fail-modal");
      }
      
      // too short
      if (pass.length < 6) {
        pass_all = false;
        $("#len").addClass("fail-modal");
      } else {
        $("#len").removeClass("fail-modal");
      }
      
      // it all works
      if (pass_all == true) {
        //visual success ques
        $("#password").addClass("success-input").removeClass("fail-input");
        $("#verify").addClass("success-input").removeClass("fail-input");
        $("#warning").hide();
        $("#nowarning").show();
        
        // activate button
        $(".dis-btn-jqtg").prop("disabled", false);
        
        // add hashed element
        var p = document.createElement("input");
     
        // Add the new element to our form. 
        form = $(this).closest("form");
        form.append(p);
        p.name = "p";
        p.type = "hidden";
        p.value = hex_sha512(password.value);
      } else {
        $(".dis-btn-jqtg").prop("disabled", true);
      }
    } else {
      // visual fail ques
      $("#password").addClass("fail-input").removeClass("success-input");
      $("#verify").addClass("fail-input").removeClass("success-input");
      $("#warning").show();
      $("#nowarning").hide();
      $(".dis-btn-jqtg").prop("disabled", true);
    }
  }
});