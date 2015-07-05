

// Constants for ease of alteration.
var BASE_COLOR = "white";
var INACTIVE_COLOR = "whitesmoke";
var BUTTON_LEAD = "[drink_type_name]";
var CLOSED_BUTTON = "glyphicon-cog";
var OPEN_BUTTON = "glyphicon-chevron-down";

// handler to check the (only) table on the page's buttons to see if they have
// been clicked. 
$("body").on("click", "table tbody tr td button", function(event){
  
  // put the pats of the DOM that we will need to use a lot into variables.
  button = $(this); // the button
  button.span = button.children('span'); //it's glyph
  button.cell = button.parent(); // it's parent cell
  button.row = button.cell.parent(); // it's parent row
  button.neighbors = button.cell.siblings(); // the rest of the row
  value = button.cell.text(); // this might need to change to some exotic if statement
  
  
  // check the type of icon, if it's either of the edit button states, do stuff
  if (button.span.hasClass(CLOSED_BUTTON)) { // if the cog
    
    //stop it from submitting
    event.preventDefault();
    
    //remove the class & add the down arrow
    button.span.toggleClass(CLOSED_BUTTON);
    button.span.toggleClass(OPEN_BUTTON);
    
    //get the record & number
    button.full = button.attr("value"); // the full name
    button.record = button.full.replace(BUTTON_LEAD,""); // the part w/o field
    
    //swap out the text for an input
    // BIG GIANT TODO HERE
    // TODO
    // TODO
    // TODO
    
    //make the button active
    button.toggleClass('active');
    
    //make siblings disabled
    button.neighbors.css("background-color", INACTIVE_COLOR);
    button.neighbors.children('button').attr('disabled', 'disabled');
    
    //show hidden rows sibling
    hiddens = $(button.row.siblings()).find(":hidden"); // get all hidden rows
    hiddens.target = hiddens.find('textarea[name*="'+ button.record + '"]'); // find the target
    hiddens.target.parent().show(400); // show the target
    
  // When it's time to hide it...
  } else if (button.span.hasClass(OPEN_BUTTON)) { // if the down arrow
    
    // stop it from submitting
    event.preventDefault();
    
    // toggle the class
    button.span.toggleClass(CLOSED_BUTTON);
    button.span.toggleClass(OPEN_BUTTON);
    
    //get the record & number
    button.full = button.attr("value"); // the full name
    button.record = button.full.replace(BUTTON_LEAD,""); // the part w/o field
    
    //deactivate the button
    button.toggleClass('active');
    
    //make siblings enabled
    button.neighbors.css("background-color", BASE_COLOR);
    button.neighbors.children('button').removeAttr('disabled');
    
    //hide the currently open row.
    button.row.siblings().find('textarea[name*="'+ button.record + '"]').parent().hide("fast");
  }
});

