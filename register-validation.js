const form = document.getElementById('regForm');

if (form) {
  const password = document.getElementById('password');
  const confirmation = document.getElementById('confirm_password');

  function validatePasswordMatch() {
    confirmation.setCustomValidity(
      confirmation.value && confirmation.value !== password.value
        ? 'Your passwords do not match.'
        : ''
    );
  }

  password.addEventListener('input', validatePasswordMatch);
  confirmation.addEventListener('input', validatePasswordMatch);
}
