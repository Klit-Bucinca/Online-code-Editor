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
  
    if (password === '' || password.length < 6) {
      alert('Password must be at least 6 characters long');
      return;
    }
  
    alert('Form submitted successfully!');
  });
  
 
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
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


  