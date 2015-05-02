<?php
// *********************** Back-end list-style tables ***********************//
/* all of the back end list tables are also forms, so all table construction
 * dealt with here will assume that the table is a form as well.
 *
 * openTable() -opens a table and a form
 * closeTable() -closes a table and a form
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

      <div class="container"> <!-- Form & table rapper -->
        <form name="' . $form . '">
          <table class="table table-hover" id="' . $table . '">';
          
  return $output;
}

/* closeTable()
 *
 * Returns a string to close up a table of the form opened by the openTable()
 * function.
 *
 * @param str $extra any extra text to be inserted between the close of the
 * table and the close of the container.
 *
 * @return str $output the HTML for the closing of the form.
 */

function closeTable($extra=null){
  $output ='
          </table>
        </form> ';

  if($extra != null) {$output .= $extra;}
  
  $output .='
      </div>';
  
  return $output;
}