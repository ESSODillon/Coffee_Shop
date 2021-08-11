/***********************************************************************************************************
 ******                            Show Brands                                                      ******
 **********************************************************************************************************/
//This function shows all brands. It gets called when a user clicks on the brands link in the nav bar.
function showBrands() {
  const url = baseUrl_API + '/api/v1/brands';

  $.ajax({
    url: url,
    headers: {
      "Authorization": "Bearer " + jwt
    }
  }).done(function (data){
    // display all the brands
    displayBrands(data);
  }).fail(function (xhr, testStatus) {
    let err = {
      "Code": xhr.status,
      "Status": xhr.responseJSON.status
    }
    showMessage('Error', JSON.stringify(err, null, 4));
  });
}

//Callback function: display all brands; The parameter is an array of brand objects.
function displayBrands(brands) {
  let _html;
  _html = `<div class='object-row object-row-header'>
        <div class='col-25'>Name</div>
        <div class='col-50'>Description</div>
        <div class='col-25 tal-r'>Number of Coffees</div>
        </div>`;
  for (let x in brands) {
    let brand = brands[x];
    _html += `<div id='brands-row-${brand.id}' class='object-row'>
            <div class='col-25'>
                <span class='list-key' data-brand='${brand.id}' 
                     onclick=showBrandCoffees('${brand.id}') 
                     title='Get cofffes from a brand'>${brand.name}
                </span>
            </div>
            <div class='col-50'>${brand.description}</div>
            <div class='col-25 tal-r'>${brand.coffees.length}</div>
            </div>`;
  }
  //Finally, update the page
  updateMain('Brands', 'All Brands', _html);
}

/***********************************************************************************************************
 ******                            Show Coffees from a Brand                                          ******
 **********************************************************************************************************/
/* Display coffees from a brand. It get called when a user clicks on a brand's name in
 * the brands list. The parameter is the brand's id.
*/
//Display coffees from a brand in a modal
function showBrandCoffees(id) {

  const name = $("span[data-brand='" + id + "']").html();
  const url = baseUrl_API + '/api/v1/brands/' + id + '/coffee';

  $.ajax({
    url: url,
    headers: {
      "Authorization": "Bearer " + jwt
    }
  }).done(function (coffees){
    console.log('displaying coffees now!');
    displayBrandCoffees(name, coffees);
  }).fail(function (xhr, testStatus) {
    let err = {
      "Code": xhr.status,
      "Status": xhr.responseJSON.status
    }
    showMessage('Error', JSON.stringify(err, null, 4));
  });
}



// Callback function that displays all coffees from a brand.
// Parameters: brand's name, an array of coffees objects
function displayBrandCoffees(brand, coffees) {
  let _html = "<div class='coffees'>No coffees were found.</div>";
  if (coffees.length > 0) {
    _html = "<table class='object-details'>" +
        "<tr>" +
        "<th>Coffee</th>" +
        "<th>Description</th>" +
        "<th>Price</th>" +
        "<th>Type</th>" +
        "</tr>";

    for (let x in coffees) {
      let aCoffee = coffees[x];
      _html += "<tr>" +
          "<td>" + aCoffee.name + "</td>" +
          "<td>" + aCoffee.description + "</td>" +
          "<td>$" + aCoffee.price.toFixed(2) + "</td>" +
          "<td class='tt-c'>" + aCoffee.type + "</td>" +
          "</tr>"
    }
    _html += "</table>"
  }

  // set modal title and content
  $('#modal-title').html("Coffees from " + brand);
  $('#modal-button-ok').hide();
  $('#modal-button-close').html('Close').off('click');
  $('#modal-content').html(_html);

  // Display the modal
  $('#modal-center').modal();
}