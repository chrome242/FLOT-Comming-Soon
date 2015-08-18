
/* A function to handle the pill and drop form of tables, allowing for AJAX updating
 *
 * @param obj event the event object
 * @param str div the div to be targeted by the call
 * @param str fileName the name of the file to post to.
 * @param bool hidden if the function has to load the hiddenToggle function.
 * 
 */
var formAjax = function (event, div, fileName){
  $('div#'+div+' button, div#'+div+ ' input[type=\"submit\"]').on('click', function(event){
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