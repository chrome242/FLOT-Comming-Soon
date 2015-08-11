
/* A function to handle the pill and drop form of tables, allowing for AJAX updating
 *
 * @param obj event the event object
 * @param str div the div to be targeted by the call
 * @param str fileName the name of the file to post to.
 * 
 */
var formAjax = function (event, div, fileName){
  $('div#'+div+' button, div#'+div+ ' input[type="submit"]').on('click', function(event){
    event.preventDefault();
    var data_save = $(this).parents('form').serializeArray();
    data_save.push ({ name: $(this).attr('name'), value: $(this).val()})
    $.ajax({
      type: 'POST',
      url: fileName+'.php',
      data: data_save,
      success: function(foo){
           $('#'+div+'').html(foo);
      }
    });
  });
}