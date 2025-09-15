function myFunction() {
  var $x = $("#password-register");
  if ($x.attr("type") === "password") {
    $x.attr("type", "text");
  } else {
    $x.attr("type", "password");
  }
}
