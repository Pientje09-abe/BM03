document.querySelector('form').addEventListener('submit', function(event) {
  const password = document.getElementById('password').value;
  if (password.length < 8) {
    alert('Password must be at least 8 characters long.');
    event.preventDefault(); // Stops the form from submitting
  }
});