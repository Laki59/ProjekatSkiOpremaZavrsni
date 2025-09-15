$(document).ready(function() {
  var $glavnaSlika = $("#glavnaSlika");
  var $malaSlika = $(".small-slika");

  $malaSlika.each(function() {
    $(this).click(function() {
      $glavnaSlika.attr("src", $(this).attr("src"));
    });
  });
});
