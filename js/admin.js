
/* A function to handle the pill and drop form of tables, allowing for AJAX updating
 *
 * @param obj event the event object
 * @param str div the div to be targeted by the call
 * @param str fileName the name of the file to post to.
 * 
 */
var formAjax = function (event, div, fileName){
  // target the div button for update, and the individual submit buttons
  var targets = 'div#'+div+' button, div#'+div+ ' input[type=\"submit\"]';
  $(targets).on('click', function(event){
    // prevent the default action
    event.preventDefault();
    // get the parent form
    var data_save = $(this).parents('form').serializeArray();
    // add the token and the button name
    data_save.push ({ name: ($(this).parents('form').attr('name') +'-token'), value: $('#'+div).attr('token') });
    data_save.push ({ name: $(this).attr('name'), value: $(this).val()});
    $.ajax({
      type: 'POST',
      url: fileName +'',
      data: data_save,
      async: true,
      success: function(foo){  // put the foo on the screen
           $('#'+div+'').html(foo);
           // set up a new copy of the function on the div.
           formAjax(event, div, fileName);
           //alert("Works!");
      }
    });
  });
}


/* A function to handle the pill and drop form of tables, allowing for AJAX updating.
 * unlike the above, the targeted version will only effect the target(s) indicated
 * by the targets param, not all submits on the form.
 *
 * @param obj event the event object
 * @param str div the div to be targeted by the call
 * @param str fileName the name of the file to post to.
 * @param mixed targets either a name or an array of targets.
 * 
 */
var targetedAxaj = function (event, div, fileName, targets){
  $('div#'+div+' button, div#'+div+ ' input[type=\"submit\"]').on('click', function(event){
    // prevent the default action
    event.preventDefault();
    alert("Fired off!");
    // get the parent form
    var data_save = $(this).parents('form').serializeArray();
    // add the token and the button name
    data_save.push ({ name: ($(this).parents('form').attr('name') +'-token'), value: $('#'+div).attr('token') });
    data_save.push ({ name: $(this).attr('name'), value: $(this).val()});
    $.ajax({
      type: 'POST',
      url: fileName +'',
      data: data_save,
      async: true,
      success: function(foo){  // put the foo on the screen
           $('#'+div+'').html(foo);
           // set up a new copy of the function on the div.
           formAjax(event, div, fileName);
           //alert("Works!");
      }
    });
  });
}

