function myFunction() {
  var $x = $("#sifra-login");
  if ($x.attr("type") === "password") {
    $x.attr("type", "text");
  } else {
    $x.attr("type", "password");
  }
}
