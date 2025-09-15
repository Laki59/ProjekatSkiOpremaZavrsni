// Uzima sve elemente sa klasom 'section'
const $sections = $('.section');

// Funkcija koja se poziva svaki put kada korisnik skroluje
function handleScroll() {
  $sections.each(function() {
    var rect = this.getBoundingClientRect();
    // Proverava da li je vrh sekcije unutar vidljivog dela prozora,
    // a donji deo sekcije nije potpuno izvan vidljivog dela
    if (rect.top < $(window).height() && rect.bottom >= 0) {
      $(this).addClass('show');
    }
  });
}

// Povezivanje funkcije na događaj skrolovanja prozora
$(window).on('scroll', handleScroll);

// Pozivanje funkcije jednom kada se DOM potpuno učita
$(document).ready(handleScroll);
