<?php
// ************************ Backend Menu Bar & Title ************************//
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
 * @return str: the html for the menu:
 */
function menubar($permissions, $section, $root){
  // This function doesn't need both user permission items, will check if
  // either is true and will add section if either is true and unset the
  // individual values.
  if($permissions["add_user"] || $permissions["edit_user"]){
    $permissions["users"] = 1;
  } else {
    $permissions["users"] = 0;
  }
  
  // inventory is also not needed as the check is for editing not view
  unset($permissions["add_user"],
        $permissions["edit_user"],
        $permissions["inventory"]);
  
  // make the button list
  // these two will always be present
  $buttons = array($root => ["Beers", 0],
                   $root."Wines/" => ["Wines", 0]);
  // the procedural portion
  foreach($permissions as $label => $state){
    if ($state == true){
      $text = ucfirst($label);
      $url = $root. $text . "/";
      $button_label = "Manage " . $text;
      $buttons[$url] = [$button_label, 1];
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
      echo"PANTS";
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