<?php
// *********************** Back-end list-style tables ***********************//
/* all of the back end list tables are also forms, so all table construction
 * dealt with here will assume that the table is a form as well.
 *
 * openTable() -opens a table and a form
 * updateButton() -makes a submit button for a form
 * closeTable() -closes a table and a form
 *
 * these forms submit to the page the forms are on. So any data will go to
 * the refering page, which needs to be able to deal with that.
 * 
 */

 /* openTable()
  *
  * Returns a string for the opening of a table wrapped in a form. This can
  * be wrapped in other functions because it's a string each table is also
  * wrapped in a container div.
  *
  * @param str $form the name of form to wrap table in.
  * @param str $table the id of the table
  *
  * @return str $output the HTML for the opening of the form.
  */
function openTable($form, $table){
  $output ='

      <div class="container"><!-- Form & Table Wrapper -->
        <form name="' . $form . '" method="post">
          <table class="table table-hover" id="' . $table . '">';
          
  return $output;
}

/* updateButton()
 *
 * Returns a string for the update button on the form.
 *
 * @param str $form the name of the form
 *
 * @return str $output the HTML for the update button
 */

 
function updateButton($form){
  // See http://bavotasan.com/2009/processing-multiple-forms-on-one-page-with-php/
  $form .= "-update"; // for use in processing.
  $output ='
          <input class="btn pull-right clearfix btn-primary" name="'. $form .'"type="submit" value="Update">';
  
  return $output;
}

/* closeTable()
 *
 * Returns a string to close up a table of the form opened by the openTable()
 * function.
 *
 * @param str $extra any extra text to be inserted between the close of the
 * table and the close of the form.
 *
 * @return str $output the HTML for the closing of the form.
 */

function closeTable($extra=null){
  $output ='
          </table>';

  if($extra != null) {$output .= $extra;}
  
  $output .='
        </form>
      </div><!-- Form & Table Wrapper-->';
  
  return $output;
}