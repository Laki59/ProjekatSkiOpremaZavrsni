// JS za pravilan unos Email-a (jQuery verzija)
function validateEmail() {
  const email = $('#email-register').val();
  const emailRegex = /[a-zA-Z0-9]+\@[a-zA-Z0-9]+\.[a-zA-Z0-9]{1,3}/;
  return emailRegex.test(email);
}

// Validira da li je email ispravan
function validateForm(event) {
  const $errorField = $('#email-error');

  if (!validateEmail()) {
    $errorField.text('Please enter a valid email address');
    event.preventDefault();
  } else {
    $errorField.text('');
  }
}
