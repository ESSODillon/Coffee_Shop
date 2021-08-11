/***********************************************************************************************************
 ******                            Show snacks                                                      ******
 **********************************************************************************************************/
//This function shows all snacks. It gets called when a user clicks on the snacks link in the nav bar.
function showSnacks() {
  const url = baseUrl_API + '/api/v1/snacks';

  axios({
    method: 'get',
    url: url,
    cache: true,
    headers: {"Authorization": "Bearer " + jwt}
  }).then(function(response) {
    displaySnacks(response.data);
  }).catch(function(error){
    handleAxiosError(error);
  });
}

//Callback function: display all snacks; The parameter is an array of snacks.
function displaySnacks(snacks, subheading = 'All Snacks') {
  let _html;
  _html = `<div class="snack-search-block">
        <input id='search-term' placeholder='Enter search terms'> 
        <button id='btn-student-search' onclick='searchStudents()'>Search</button></div>
        <br><br>
        <div class='object-row object-row-header'>
        <div class="col-25">Name</div>
        <div class="col-25">Description</div>
        <div class="tal-r col-25">Price</div>
        <div class="col-25">Type</div>
        </div>`;
  for (let x in snacks) {
    let snack = snacks[x];
    _html += `<div id='snacks-row-${snack.id}' class='object-row'>
            <div class="col-25">${snack.name}</div>
            <div class="col-25">${snack.description}</div>
            <div class='tal-r col-25'>$${snack.price.toFixed(2)}</div>
            <div class="col-25 tt-c">${snack.type}</div>
            </div>`;
  }

  //Finally, update the page
  updateMain('Snacks', subheading, _html);
}

/* This function handles errors occurred by an axios request */
function handleAxiosError(error) {
  let errMessage;
  if (error.response) {
    // Request was made and the server responded with a status code of 4xx or 5xx
    errMessage = {
      "Code": error.response.status,
      "Status": error.response.data.status
    };
  } else if (error.request) {
    // the request was made but no response was received
    errMessage = {
      "Code": error.request.status,
      "Status": error.request.data.status
    };
  } else {
    // Something happened in setting up the request that resulted in an error
    errMessage = JSON.stringify(error.message, null, 4)
  }

  showMessage('Error', errMessage);
}

/***********************************************************************************************************
 ******                            Search Students                                                    ******
 **********************************************************************************************************/
function searchStudents() {
  // console.log('searching for students');
  let term = $('#search-term').val();
  const url = baseUrl_API + '/api/v1/snacks?q=' + term;

  // Update the subheadering according to the term;
  let subheading = '';
  if (term == '') { // search term is empty
    subheading = 'All Snacks';
  } else { // search term is a number
    subheading = 'Snacks containing ' + term;
  }

  fetch(url, {
    method: 'GET',
    headers: {
      "Authorization": "Bearer " + jwt
    }
  }).then(checkFetch) // check for errors
      .then(response => response.json())
      .then(snacks => displaySnacks(snacks, subheading)) // display students
      .catch(err => showMessage('Errors', err))
}