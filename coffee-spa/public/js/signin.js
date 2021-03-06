//global variables
var jwt = '';   //JSON Web token
var role = '';  //user's role: 1 for admins and 2 for regular users

//This function get called when the signin hash is clicked.
function signin() {
    $('.img-loading, main, .form-signup, #li-signout, #li-signup').hide();
    $('.form-signin, #li-signin').show();
    $("li#li-professor > a, li#li-course > a, li#li-student > a").addClass('disabled');

    // Remove these two lines once the lab is done
    $('#signin-username').val('admin');
    $('#signin-password').val('password');
}

//submit username and password to be verified by the API server
$('form.form-signin').submit(function (e) {
	$('img-loading').show();
	e.preventDefault();
	let username = $('#signin-username').val();
	let password = $('#signin-password').val();

	// URL to the API server
	const url = baseUrl_API + '/api/v1/users/authJWT';

	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {username: username, password: password}
	}).done(function (data){
		$('.img-loading').hide();
		jwt = data.jwt;
		role = data.role;

		// The user has been successfully signed in.
		// Enable all the links in the nav bar
		// Hide sign in link and show sign out link
		$('a.nav-link.disabled').removeClass('disabled'); // Enable all the links
		$('li#li-signin').hide(); // Hide the sign in link
		$('li#li-signout').show(); // Show the sign out link
		showMessage('Signin Message', 'You have successfully signed in. Click on the links in the nav bar to explore the site.');

	}).fail(function(jqXHR, textStatus) {
		showMessage('Signin Error', JSON.stringify(jqXHR.responseJSON, null, 4));
	}).always(function() {
		// Run code regardless the request is successful or failed.
	});

});