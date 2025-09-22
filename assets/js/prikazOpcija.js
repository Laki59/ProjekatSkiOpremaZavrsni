  $(document).ready(function () {
    $("#product_type_select").on("change", function () {
      if ($(this).val() === "rent") {
        $("#rental_dates").show();
      } else {
        $("#rental_dates").hide();
      }
    });
  });