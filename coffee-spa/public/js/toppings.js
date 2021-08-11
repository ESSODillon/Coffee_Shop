/***********************************************************************************************************
 ******                            Show toppings                                                      ******
 **********************************************************************************************************/
//This function shows all toppings. It gets called when a user clicks on the toppings link in the nav bar.
function showToppings() {
  const url = baseUrl_API + "/api/v1/toppings";

  fetch(url, {
    method: "GET",
    headers: {
      Authorization: "Bearer " + jwt,
    },
  })
    .then(checkFetch) // check for errors
    .then((response) => response.json())
    .then((toppings) => displayToppings(toppings)) // display toppings
    .catch((err) => showMessage("Errors", err));
}

//Callback function: display all toppings; The parameter is an array of toppings.
// The first parameter is an array of toppings and second parameter is the subheading, defaults to null.
function displayToppings(toppings, subheading = null) {

  // row of headings
  let _html = `<div style='text-align: right; margin-bottom: 3px'>
            <div class='content-row content-row-header'>
            <div class='student-id'>Topping ID</div>
            <div class='student-name'>Name</div>
            <div class='student-email'>Price</div>
            </div>`;  //end the row

  // content rows
  for (let x in toppings) {
    let topping = toppings[x];
    _html += `<div class='content-row'>
            <div class='student-id'>${topping.id}</div>
            <div class='student-name' id='student-edit-name-${topping.id}'>${topping.name}</div> 
            <div class='student-price' id='student-edit-price-${topping.id}'>${topping.price}</div>`;
    if (role == 1) {
      _html += `<div class='list-edit'><button id='btn-student-edit-${topping.id}' onclick=editTopping('${topping.id}') class='btn-light'> Edit </button></div>
            <div class='list-update'><button id='btn-student-update-${topping.id}' onclick=updateTopping('${topping.id}') class='btn-light btn-update' style='display:none'> Update </button></div>
            <div class='list-delete'><button id='btn-student-delete-${topping.id}' onclick=deleteTopping('${topping.id}') class='btn-light'>Delete</button></div>
            <div class='list-cancel'><button id='btn-student-cancel-${topping.id}' onclick=cancelUpdateTopping('${topping.id}') class='btn-light btn-cancel' style='display:none'>Cancel</button></div>`;
    }
    _html += "</div>"; //end the row
  }

  //the row of element for adding a new topping
  if (role == 1) {
    _html += `<div class='content-row' id='student-add-row' style='display: none'> 
            <div class='student-id'></div>
            <div class='student-name student-editable' id='student-new-name' contenteditable='true'></div>
            <div class='student-price student-editable' id='student-new-price' contenteditable='true'></div>
            <div class='list-update'><button id='btn-add-student-insert' onclick='addTopping()' class='btn-light btn-update'> Insert </button></div>
            <div class='list-cancel'><button id='btn-add-student-cancel' onclick='cancelAddTopping()' class='btn-light btn-cancel'>Cancel</button></div>
            </div>`; //end the row

    // add new topping button
    _html += `<div class='content-row student-add-button-row'><div class='student-add-button' onclick='showAddRow()'>+ ADD NEW TOPPING</div></div>`;
  }
  //Finally, update the page
  subheading = subheading == null ? "All Toppings" : subheading;
  updateMain("Toppings", subheading, _html);
}

/***********************************************************************************************************
 ******                            Edit Topping                                                       ******
 **********************************************************************************************************/

// This function gets called when a user clicks on the Edit button to make items editable
function editTopping(id) {
  //Reset all items
  resetTopping();

  //select all divs whose ids begin with 'topping' and end with the current id and make them editable
  $("div[id^='student-edit'][id$='" + id + "']").each(function () {
    $(this).attr("contenteditable", true).addClass("student-editable");
  });

  $(
    "button#btn-student-edit-" + id + ", button#btn-student-delete-" + id
  ).hide();
  $(
    "button#btn-student-update-" + id + ", button#btn-student-cancel-" + id
  ).show();
  $("div#student-add-row").hide();
}

//This function gets called when the user clicks on the Update button to update a topping record
function updateTopping(id) {
  //console.log('update the topping whose id is ' + id);
  let data = {};

  //Select all divs whose ids begin with 'topping-edit-' and end with the current id.
  //Extract topping details from the divs and create a JSON object
  $("div[id^='student-edit-'][id$='" + id + "']").each(function () {
    let field = $(this).attr("id").split("-")[2]; //The second part of an ID is the field name
    let value = $(this).html(); //content of the div
    data[field] = value;
  });

  //Make a fetch request to update the topping
  const url = baseUrl_API + "/api/v1/toppings/" + id;
  fetch(url, {
    method: "PUT",
    headers: {
      Authorization: "Bearer " + jwt,
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then(checkFetch)
    .then(() => resetTopping()) //reset toppings
    .catch((err) => showMessage("Errors", err));
}

//This function gets called when the user clicks on the Cancel button to cancel updating a topping
function cancelUpdateTopping(id) {
  showToppings();
}

/***********************************************************************************************************
 ******                            Delete Topping                                                     ******
 **********************************************************************************************************/

// This function confirms deletion of a topping. It gets called when a user clicks on the Delete button.
function deleteTopping(id) {
  $("#modal-button-ok")
    .html("Delete")
    .show()
    .off("click")
    .click(function () {
      removeTopping(id);
    });
  $("#modal-title").html("Delete Topping");
  $("#modal-content").html("Are you sure you want to delete the topping?");
  $("#modal-button-close").html("Cancel").show().off("click");

  // Display the modal
  $("#modal-center").modal();
}

// Callback function that removes a topping from the system. It gets called by the deleteTopping function.
function removeTopping(id) {
  //console.log('remove the topping whose id is ' + id);
  let url = baseUrl_API + "/api/v1/toppings/" + id;
  fetch(url, {
    method: "DELETE",
    headers: { Authorization: "Bearer " + jwt },
  })
    .then(checkFetch)
    .then(() => showToppings()) //reload the toppings
    .catch((err) => showMessage("Errors", err));
}

/***********************************************************************************************************
 ******                            Add Topping                                                        ******
 **********************************************************************************************************/
//This function shows the row containing editable fields to accept user inputs.
// It gets called when a user clicks on the Add New Topping link
function showAddRow() {
  resetTopping(); //Reset all items
  $("div#student-add-row").show();
}

//This function inserts a new topping. It gets called when a user clicks on the Insert button.
function addTopping() {
  //console.log('Add a new topping');
  let data = {};

  //Retrieve new topping details and create a JSON object
  $("div[id^='student-new-']").each(function () {
    let field = $(this).attr("id").substr(12); //The last part of an ID is the field name. There are 12 characters before the field name.
    let value = $(this).html(); //content of div
    data[field] = value;
  });

  //send the request via fetch
  const url = baseUrl_API + "/api/v1/toppings";

  fetch(url, {
    method: "POST",
    headers: {
      Authorization: "Bearer " + jwt,
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then(checkFetch)
    .then(() => showToppings()) //reload the topping list
    .catch((err) => showMessage("Errors", err));
}

// This function cancels adding a new topping. It gets called when a user clicks on the Cancel button.
function cancelAddTopping() {
  $("#student-add-row").hide();
}

/***********************************************************************************************************
 ******                            Check Fetch for Errors                                             ******
 **********************************************************************************************************/
/* This function checks fetch request for error. When an error is detected, throws an Error to be caught
 * and handled by the catch block. If there is no error detected, returns the promise.
 * Need to use async and await to retrieve JSON object when an error has occurred.
 */
let checkFetch = async function (response) {
  if (!response.ok) {
    await response
      .json() //need to use await so Javascript will until promise settles and returns its result
      .then((result) => {
        throw Error(JSON.stringify(result, null, 4));
      });
  }
  return response;
};

/***********************************************************************************************************
 ******                            Reset topping section                                             ******
 **********************************************************************************************************/
//Reset topping section: remove editable features, hide update and cancel buttons, and display edit and delete buttons
function resetTopping() {
  // Remove the editable feature from all divs
  $("div[id^='student-edit-']").each(function () {
    $(this).removeAttr("contenteditable").removeClass("student-editable");
  });

  // Hide all the update and cancel buttons and display all the edit and delete buttons
  $("button[id^='btn-student-']").each(function () {
    const id = $(this).attr("id");
    if (id.indexOf("update") >= 0 || id.indexOf("cancel") >= 0) {
      $(this).hide();
    } else if (id.indexOf("edit") >= 0 || id.indexOf("delete") >= 0) {
      $(this).show();
    }
  });
}
