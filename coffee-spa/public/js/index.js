var oldHash = "";

var baseUrl_API = "http://localhost/Course-project/public"; //local server

$(function () {
  //Handle hashchange event; when a click is clicked, invoke an appropriate function
  window.addEventListener("hashchange", function (event) {
    let hash = location.hash.substr(1); //need to remove the # symbol at the beginning.
    oldHash = event.oldURL.substr(event.oldURL.indexOf("#") + 1);

    if ($("a[href='#" + hash + "'").hasClass("disabled")) {
      showMessage(
        "Signin Error",
        'Access is not permitted. Please <a href="index.php#signin">sign in</a> to explore the site.'
      );
      return;
    }

    //set active link
    $("li.nav-item.active").removeClass("active");
    $("li.nav-item#li-" + hash).addClass("active");

    //call appropriate function depending on the hash
    switch (hash) {
      case "home":
        home();
        break;
      case 'brands':
        showBrands();
        break;
      case 'coffees':
        showCoffees();
        break;
      case 'toppings':
        showToppings();
        break;
      case 'snacks':
        showSnacks();
        break;
      case "signin":
        signin();
        break;
      case "signup":
        signup();
        break;
      case "signout":
        signout();
        break;
      case "message":
        break;
      default:
        home();
    }
  });
  if (jwt == "") {
    //display homepage content and set the hash to 'home'
    home();
    window.location.hash = "home";
  }
});

// This function sets the content of the homepage.
function home() {
  let _html = `<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a eros ligula. Maecenas ut sapien tincidunt, imperdiet ex eu, condimentum dolor. Donec eget odio vel mauris congue suscipit eu a leo. Aenean suscipit, turpis a fermentum luctus, nisi sapien aliquam neque, a pharetra neque eros at metus. Curabitur condimentum eget nunc eget tincidunt. Pellentesque molestie nibh erat, eu fringilla mauris ornare vel. Nam fringilla, leo nec rhoncus malesuada, nisi nunc efficitur tortor, in pretium ex mi in nisl. Praesent quis quam at risus hendrerit egestas. Pellentesque leo risus, feugiat vel laoreet vel, commodo eget augue.</p>

  <p>In scelerisque volutpat dolor, a tempus lorem ultrices ut. In enim nibh, hendrerit ut suscipit posuere, finibus eget felis. Proin metus mi, tincidunt ac volutpat vitae, pharetra vehicula eros. In et pharetra erat. Pellentesque tincidunt urna ullamcorper nisl malesuada lacinia. Proin dignissim a felis ut euismod. Praesent scelerisque, velit vitae auctor posuere, ante dolor consequat nisl, blandit sodales orci ex non ante. Nullam nec hendrerit neque.</p>`;

  // Update the section heading, sub heading, and content
  updateMain("Home", "Welcome to It's a Grind Coffee Shop", _html);
}

// This function updates main section content.
function updateMain(main_heading, sub_heading, section_content) {
  $("main").show(); //show main section
  $(".form-signup, .form-signin").hide(); //hide the sign-in and sign-up forms

  //update section content
  $("div#main-heading").html(main_heading);
  $("div#sub-heading").html(sub_heading);
  $("div#section-content").html(section_content);
}
