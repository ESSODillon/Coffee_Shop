/***********************************************************************************************************
 ******                            Show Coffees                                                      ******
 **********************************************************************************************************/
//This function shows all coffees. It gets called when a user clicks on the coffees link in the nav bar.
function showCoffees(offset = 0) {
  let limit = ($('#coffee-limit-select').length) ? $('#coffee-limit-select option:checked').val() : 5;
  let sort = ($('#coffee-sort-select').length) ? $('#coffee-sort-select option:checked').val() : 'id:asc';

  const url = baseUrl_API + '/api/v1/coffee?limit=' + limit + '&offset=' + offset + '&sort=' + sort;

  axios({
    method: 'get',
    url: url,
    cache: true,
    headers: {"Authorization": "Bearer " + jwt}
  }).then(function(response) {
    displayCoffees(response.data);
  }).catch(function(error){
    handleAxiosError(error);
  });

}

//Callback function: display all coffees; The parameter is an array of coffee objects.
function displayCoffees(response) {
  let _html;
  _html = `<div class='object-row object-row-header'>
        <div class='col-25'>Name</div>
        <div class='col-25'>Brand</div>
        <div class='col-25'>Description</div>
        <div class='col-12-5'>Type</div>
        <div class='col-12-5 tal-r'>Price</div>
        </div>`;
  let coffees = response.data;
  for (let x in coffees) {
    let coffee = coffees[x];
    _html += `<div id='coffees-row-${coffee.id}' class='object-row'>
            <div class='col-25'>${coffee.name}</div>
            <div class='col-25'>
                <span class='list-key' data-brand='${coffee.id}'
                     onclick=displayCoffeeBrandDetails('${coffee.brand.id}') 
                     title='Get coffees from a brand'>${coffee.brand.name}
                </span>
            </div>
            <div class='col-25'>${coffee.description}</div>
            <div class='col-12-5 tt-c'>${coffee.type}</div>
            <div class='col-12-5 tal-r'>$${coffee.price.toFixed(2)}</div>
            </div>`;
  }
  //Add a div block for pagination
  _html += "<div class='content-row coffee-pagination'><div>";

  //pagination
  _html += paginationCoffee(response);

  //Limit Coffees
  _html += limitCoffees(response);

  //sort coffees
  _html += sortCoffees(response);

  //close the div blocks
  _html += "</div></div>";

  //Finally, update the page
  updateMain('Coffees', 'All Coffees', _html);
}

// Callback function that displays all brand information
// Parameters: brand id
function displayCoffeeBrandDetails(id) {
  const url = baseUrl_API + '/api/v1/brands/' + id;

  axios({
    method: 'get',
    url: url,
    cache: true,
    headers: {"Authorization": "Bearer " + jwt}
  }).then(function(response) {

    let data = response.data;
      // display all the brand info
      let _html = "<div>No info was found.</div>";
      if (data) {
        _html = `<div><strong>${data.name}</strong></div><br>` +
                `<div>${data.description}</div>`;
      }

      // set modal title and content
      $('#modal-title').html("Brand Info");
      $('#modal-button-ok').hide();
      $('#modal-button-close').html('Close').off('click');
      $('#modal-content').html(_html);

      // Display the modal
      $('#modal-center').modal();
  }).catch(function(error){
    handleAxiosError(error);
  });

}
//Pagination coffee
function paginationCoffee(response){
  //Calculate the total number of pages
  let limit = response.limit;
  let totalCount = response.totalCount;
  let totalPages = Math.ceil(totalCount/limit);

  //Determine the current page showing
  let offset = response.offset;
  let currentPage = offset/limit + 1;

  //Retrieve the array of links from the response json
  let links = response.links;
  console.log(links);

  //Convert an array of links to JSON document
  let pages = {};

  //Extract offset from each link and store it in pages
  links.forEach(function(link) {
    let urlParams = new URLSearchParams(link.href);
    pages[link.rel] = urlParams.get('offset');
  });

  if(!pages.hasOwnProperty('prev')){
    pages.prev = pages.self;
  }

  if(!pages.hasOwnProperty('next')){
    pages.next = pages.self;
  }

  //Generate HTML code for links
  let _html = `Showing Page ${currentPage} of ${totalPages} <span class="coffee-pagination">
                <a href='#coffee' title="first page" onclick='showCoffees(${pages.first})'> << </a>
                <a href='#coffee' title="previous page" onclick='showCoffees(${pages.prev})'> < </a>
                <a href='#coffee' title="next page" onclick='showCoffees(${pages.next})'> > </a>
                <a href='#coffee' title="last page" onclick='showCoffees(${pages.last})'> >> </a></span>`;

  return _html;
}

//Limit Coffees
function limitCoffees(response){
  //Define an array of coffees per page options
  let coffeePerPageOptions = [1, 3, 5];

  //create a selection list for limiting coffees
  let _html = `&nbsp;&nbsp;&nbsp;&nbsp; Items per page:<select id='coffee-limit-select' onChange='showCoffees()'>`;

  coffeePerPageOptions.forEach(function(option){
    let selected = (response.limit == option) ? "selected" : "";
    _html +=  `<option ${selected} value="${option}">${option}</option>`;
  });

  _html += "</select>"

  return _html;
}

//Sort coffees
function sortCoffees(response){
  //Create the selection list for sorting
  let sort = response.sort;

  //Sort field and direction
  let sortString = JSON.stringify(sort).replace(/["{}]+/g, "");

  //Define a JSON containing sort options
  let sortOptions = {
    "name:asc": "Name A - Z",
    "name:desc": "Name Z - A",
    "price:asc": "Price $ - $$$",
    "price:desc": "Price $$$ - $"
  };

  //Create the selection list
  let _html = `&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sort by:<select id='coffee-sort-select' onChange=showCoffees()>`;
  for (let option in sortOptions) {
    let selected = (option == sortString) ? "selected" : "";
    _html += `<option ${selected} value="${option}">${sortOptions[option]}</option>`;
  }
  _html += "</select>";

  return _html;
}
