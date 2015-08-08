

$(function(){
  $('form button').on('click', function(e){
    e.preventDefault();
    var data_save = $(this).parents('form').serializeArray();
    data_save.push ({ name: $(this).attr('name'), value: $(this).val()})
    alert('Name =' + $(this).attr('name') +'/nValue= ' + $(this).val());
    $.ajax({
      type: 'POST',
      url: 'testpost.php',
      data: data_save,
      success: function(foo){
           $('#userGroups').html(foo);
      }
    });
  });
});
