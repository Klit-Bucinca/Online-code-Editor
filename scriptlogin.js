document.getElementById('logInForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Stop form from reloading

    const name = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (name === '') {
        alert('Name is required');
        return;
    }

    if (password === '') { 
        alert('Password is required');
        return;
    }

    fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `username=${encodeURIComponent(name)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server Response:", data.trim()); // Debugging

        if (data.trim() === "admin") {
            window.location.href = "admin.php"; // Redirect "Admin" user
        } else if (data.trim() === "success") {  
            window.location.href = "Main.php"; // ✅ Redirect normal users to main.html
        } else {
            alert(data); // Show error message
        }
    })
    .catch(error => console.error('Fetch error:', error));
});
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