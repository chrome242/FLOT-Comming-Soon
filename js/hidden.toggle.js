

// Constants for ease of alteration.
var BASE_COLOR = "white";
var INACTIVE_COLOR = "whitesmoke";
var BUTTON_LEAD = "[drink_type_name]";
var CLOSED_BUTTON = "glyphicon-cog";
var OPEN_BUTTON = "glyphicon-chevron-down";
var ADD_BUTTON = "glyphicon-plus";

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
  value = value.trim(); // clean the random spaces it puts on the end because IDK
  
  // check the type of icon, if it's either of the edit button states, do stuff
  if (button.span.hasClass(CLOSED_BUTTON)) { // if the cog
    
    //stop it from submitting
    event.preventDefault();
    
    //remove the class & add the down arrow
    button.span.toggleClass(CLOSED_BUTTON);
    button.span.toggleClass(OPEN_BUTTON);
    
    //get the record & number
    button.full = button.attr("value"); // the full name
    button.record = button.full.replace(BUTTON_LEAD,""); // Strip the front off.
    
    // swap out the text for an input
    // check to see if there is text ( a note on approach: you can't just check
    // for the ammoutn of text == 0 because it will count all the non-text in
    // the element as text but not display that stuff) So the fix is to check
    // how many children elements the cell has (2 for with an input, 1 for with
    // text), and respond to that if needed.
    if ($(button.cell).children().length == 1) {
      
      //if so, remove the text
      $(button.cell).contents().filter(function(){
        return this.nodeType === 3;
      }).remove();
      // the name and id of the input can be gotten from the button value
      var idName = button.val();
      // construct the input using the info off the button
      var inputElement = '<input type="text" class="form-control edit-field-wine" id="'
                          + idName + '" name = "' + idName +  '" value="' + value + '">';
      // append to the cell
      $(button).before(inputElement);      
    }
    
    //make the button active
    button.toggleClass('active');
    
    //make siblings disabled
    button.neighbors.css("background-color", INACTIVE_COLOR);
    button.neighbors.children('button').attr('disabled', 'disabled');
    
    //show hidden rows sibling
    hiddens = $(button.row.siblings()).find(":hidden"); // get all hidden rows
    hiddens.target = hiddens.find('textarea[name*="'+ button.record + '"]'); // find the target
    hiddens.target.parent().show(400); // show the target
    
    console.log($(button.cell).children().length);

    
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
//  else if (button.span.hasClass(ADD_BUTTON)) { // if the add button.
    // check to see if there's another open item in the same row, if so, close (hide)
    // it's text desc.
    
    // copy the current cell, so it can be placed elsewhere.
    // check the last cell to see if it has a name that ends with a n, if so,
    // get the number before that n, and add 1 to it otherwise, counter = 1
    
    // add hidden cell
    
    // check to see where the new add cell should be added, add new line if need
    
//  }
});

