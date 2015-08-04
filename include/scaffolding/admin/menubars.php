<?php
// ************************ Back-end Menu Bars & Title ***********************//
/* Contains 3 functions that display different menu bars:
 * menubar() -displays the main menu bar for the admin section.
 * sectionbar() -displays data-target sub-menu bars
 * sortbar() -displays the sort menu bar for the beers.
 */



/* menubar()
 *
 * Has narrow assumptions of $permissions and $section
 * 
 * Returns the masthead and the and the nav bar. Navbar view is based on the
 * $permissions, which should be passed from the file. This function does no
 * rights or access checking, assumes that the calling file has done so.
 * @param array bool $permissions: an array of the permissions in key => bool
 * @param string $section: the section that should be selected on the nav bar
 * @param string $root: the home section (eg /Admin/)
 *
 * @return str: the HTML for the menu.
 */
function menubar($permissions, $section, $root){
  // This function doesn't need both user permission items, will check if
  // either is true and will add section if either is true and unset the
  // individual values.
  if($permissions["add_user"] || $permissions["edit_user"]){
    $permissions["users"] = 2;
  } else {
    $permissions["users"] = 1;
  }
  
  // inventory is also not needed as the check is for editing not view
  unset($permissions["add_user"],
        $permissions["edit_user"],
        $permissions["inventory"]);
  
  // make the button list
  // these two will always be present
  $buttons = array($root => ["Beers", 1],
                   $root."Wines/" => ["Wines", 1]);
  // the procedural portion
  foreach($permissions as $label => $state){
    if ($state == 2){
      $text = ucfirst($label);
      $url = $root. $text . "/";
      $button_label = "Manage " . $text;
      $buttons[$url] = [$button_label, 2];
    }  
  }
  
  // make the return statement:
  $output = '
      <div class="masthead"><!-- Nav -->
        <h3 class="text-muted">Finger Lakes on Tap Inventory</h3>
         <ul class="nav nav-justified">';
  foreach($buttons as $url => $html){
    $list_item = "";
    if($url == $section) {

      $list_item.='
          <li class="active">';
    } else{
      $list_item.='
          <li>';
    }
    
    if($html[1] == 1){
      $list_item.='
            <a class="long-text" href="'.$url.'">'.$html[0].'</a>
          </li>';
    } else{
      $list_item.='
            <a href="'.$url.'">'.$html[0].'</a>
          </li>';
    }
    $output .= $list_item;
  }
  $output .= '
        </ul>
      </div><!-- /Nav -->';
  return $output;
  
}



/* sortbar()
 *
 * Returns a same page subsection nav bar for sorting by a selection.
 * Won't do much with out some javascript to handel hiding and showing things.
 *
 * @param array str $options: an array of: button id => text
 * @param str $default: the default option on the menubar
 *
 * @return str: the HTML for the menu.
 */

function sortbar($options, $default) {
  
  // open the div
  $output = '
  
      <div class="btn-group sort-bar"><!-- Sort Bar -->';
  
  // add the options
  foreach($options as $htmlid => $text){
    $htmlclass = "btn-default";
    if($htmlid == $default){$htmlclass = "btn-primary";} //set primary button
    $output .= '
        <a class="btn ' . $htmlclass . '" id ="' . $htmlid . '">' . $text .'</a>';
  }
  
  // close the div
  $output .= '
      </div><!-- /Sort Bar -->';
  return $output;
}


/* sectionbar()
 *
 * Returns a Subsection nav that has aria controls for hiding and showing the
 * various subsections of the page. Will need to have matching hooks in sections
 * to do anything.
 *
 * @param array array $options an array of: button id =>[text, starts expanded]
 * @param mixed $dummy if not false, adds a button to the bar with no associated
 *                     data target at the end of the series with an id & text of
 *                     the $dummy value.
 *
 * @return str: the HTML for the menu.
 */
function sectionbar($options, $dummy=false){
  // open the div
  $output = '
  
      <div class="container"> <!-- Subsection Nav -->
        <div class="row">';
  foreach($options as $ariacontrols => $details){
    $expanded = "false";
    if($details[1] == true){ $expanded = "true";} // set expanded if true
    $text = $details[0];
    $output .='
          <button class="btn btn-primary top-button" type="button" data-toggle="collapse" data-target="#' .$ariacontrols. '" aria-expanded="'.$expanded.'" aria-controls="'.$ariacontrols.'">
            '. $text .'
          </button>';
  }
  
  if($dummy !== false){
    $output .='
          <button class="btn btn-primary top-button" type="button" id="'.$dummy.'">
            '. $dummy .'
          </button>';
  }
  
  // close the div
  $output .= '
        </div>
      </div><!-- /Subsection Nav -->';
  return $output;
}

/** getActivePanels()
 *
 * A function to return what the source of the $_POST was from a page with a
 * number of posting tables, and return the name of the correct table. Assumes
 * that the tables are posting in the form $tablename-$action
 *
 * @param array $post the $_POST array
 *
 * @return str the name of the posting form
 */
function getActivePanels($post){
  foreach (array_keys($post) as $key){
    $chunk = strstr($key, "-", true);
    if($chunk){return $chunk;}
  }
}

/** activatePanels()
 * Checks to see if the active array is set, if so, it finds the member of the
 * section array with the matching key => value[2] and changes value [1] to true.
 *
 * @param array &$sectionArray the section array to be mutated.
 * @param mixed $active either false or a value to be found in the $sectionArray
 *
 * @return array the modified $sectionArray
 */
function activatePanel(&$sectionArray, $active){
  if($active){
    foreach($sectionArray as $key => $value){
      if($value[2] == $active){
        $value[1] = true;}
    }
  }
  
  return $sectionArray;
}