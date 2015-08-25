

// Constants for ease of alteration.
var BASE_COLOR = "white";
var INACTIVE_COLOR = "whitesmoke";
var BUTTON_LEAD = "[drink_type_name]";
var DROPDOWN_LEAD = "[drink_type_desc]";
var TABLE_NAME = "drinktypes";
var CLOSED_BUTTON = "glyphicon-cog";
var OPEN_BUTTON = "glyphicon-chevron-down";
var ADD_BUTTON = "glyphicon-plus";
var EMPTY = '                    <tr>\
                      <td colspan="4" hidden>\
                        <textarea class="form-control edit-field"rows="3" id="drinktypes[add][drink_type_desc]" name="drinktypes[add][drink_type_desc]"></textarea>\
                        <button type="submit" class="btn btn-primary edit-icon" id="drinktypes[add][drink_type_desc][drinktypes-drop]" name="drinktypes-drop" value="drinktypes[add][drink_type_desc]">Drop</button>\
                      </td>\
                    </tr>';
var EDITSTART = '                    <tr>\
                      <td class="col-xs-3">\
                        <input type="text" class="form-control edit-field-wine"id="drinktypes[add][drink_type_name]" name="drinktypes[add][drink_type_name]" placeholder="" disabled>\
                        <button type="submit" class="btn btn-primary edit-icon btn-sm" id="drinktypes[add][drink_type_name][drinktypes-new]" name="drinktypes-new" value="drinktypes[add][drink_type_name]"><span class="glyphicon glyphicon-plus"></span></button>\
                      </td>\
                      <td></td>\
                      <td></td>\
                      <td></td>\
                    </tr>';
// variable for number additions:
var cell_counter = 1;

// handler to check the (only) table on the page's buttons to see if they have
// been clicked. 
$("body").on("click", "table tbody tr td button", function(event){
  
  // put the pats of the DOM that we will need to use a lot into variables.
  button = $(this); // the button
  button.span = button.children('span'); //it's glyph
  button.cell = button.parent(); // it's parent cell
  button.row = button.cell.parent(); // it's parent row
  button.neighbors = button.cell.siblings(); // the rest of the row
  button.table = button.row.parent(); // because I need all of these
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
  else if (button.span.hasClass(ADD_BUTTON)) { // if the add button.
    
    // stop the default from occuring
    event.preventDefault();
    
    // make a clone of this cell.
    newcell = button.cell.clone();
    
    //get the record & number
    button.full = button.attr("value"); // the full name
    button.record = button.full.replace(BUTTON_LEAD,""); // the part w/o field
    
    //find the hidden sibling with the same value as the button record
    hiddens = $(button.row.siblings()).find(":hidden"); // get all hidden rows
    hiddens.target = hiddens.find('textarea[name*="'+ button.record + '"]'); // find the target

    // update all the attribs with the new name
    newcount = '[' + cell_counter + 'n]'; // the new name
    cell_counter += 1; // up the counter
    //button id
    button.attr("id", button.attr("id").replace("[add]", newcount).replace("-new", "-edit"));
    //button name -new to -edit
    button.attr("name", button.attr("name").replace("-new", "-edit"));
    //button value
    button.val(button.attr("id").replace("[drinktypes-edit]", ""));
    //button icon
    button.span.toggleClass(ADD_BUTTON);
    button.span.toggleClass(OPEN_BUTTON);
    
    //cell input
    button.input = $(button.cell).find('input');
    button.input.prop("disabled", false).removeAttr("placeholder");
    button.input.attr("id", button.val()).attr("name", button.val());
    
    //dropbutton id
    hiddens.target.attr("id", TABLE_NAME + newcount + DROPDOWN_LEAD);
    //dropbutton value
    hiddens.target.attr("name", TABLE_NAME + newcount + DROPDOWN_LEAD);
    
    parent = hiddens.target.parent();
    parent.children("button").attr("id").replace("[add]", newcount);
    newval = parent.children("button").attr("id").replace("[add]", newcount);
    parent.children("button").val(newval);
    
    hiddens.target.parent().show(400); // show the target

    //make the button active
    button.toggleClass('active');
    
    //make siblings disabled
    button.neighbors.css("background-color", INACTIVE_COLOR);
    button.neighbors.children('button').attr('disabled', 'disabled');
    
    // if the cell is the last child...
    if ($(button.cell).is(":last-child")) {
      $(button.table).append(EDITSTART);
      $(button.table).append(EMPTY)
    } else {
      // if the cell is not the last cell on the row:
      $(button.cell).next().replaceWith(newcell);
      
      // add the new row to the table
      $(button.table).append(EMPTY);
    }
    
    
  }
});

