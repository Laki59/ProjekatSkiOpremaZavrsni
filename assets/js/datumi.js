  $(document).ready(function () {
    const $startDateInput = $("#start_date");
    const $endDateInput = $("#end_date");

    //Ubacivanje startnog datuma
    $startDateInput.on("change", function () {
      if ($(this).val()) {
        let start = new Date($(this).val());

        // min = start date
        let minEnd = new Date(start);
        // max = start date + 8 dana
        let maxEnd = new Date(start);
        maxEnd.setDate(maxEnd.getDate() + 8);

        // formatiranje datuma u YYYY-MM-DD
        const formatDate = (d) => d.toISOString().split("T")[0];

        //Dozvoljeni raspon za krajnji datum
        $endDateInput.attr("min", formatDate(minEnd));
        $endDateInput.attr("max", formatDate(maxEnd));

        //Otkljuca polje i podesi verdnost
        $endDateInput.prop("disabled", false); 
        $endDateInput.val(formatDate(minEnd)); 
      }
    });
  });