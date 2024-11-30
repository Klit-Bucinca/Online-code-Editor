document.getElementById('signupForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();

  if (name === '') {
      alert('Name is required');
      return;
  }

  if (email === '' || !validateEmail(email)) {
      alert('Valid email is required');
      return;
  }

  if (!validatePassword(password)) {
      alert('Password must be at least 8 characters long, include at least one uppercase letter, and contain at least one number.');
      return;
  }

  alert('Form submitted successfully!');
});


function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}


function validatePassword(password) {
  const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
  return passwordRegex.test(password);
}


const passwordInput = document.getElementById('password');
const togglePasswordButton = document.getElementById('togglePassword');
const eyeIcon = togglePasswordButton.querySelector('.eye-icon');

togglePasswordButton.addEventListener('click', () => {
  const isPassword = passwordInput.type === 'password';
  passwordInput.type = isPassword ? 'text' : 'password';

  if (isPassword) {
      eyeIcon.classList.remove('closed-eye');
      eyeIcon.classList.add('open-eye');
  } else {
      eyeIcon.classList.remove('open-eye');
      eyeIcon.classList.add('closed-eye');
  }
});