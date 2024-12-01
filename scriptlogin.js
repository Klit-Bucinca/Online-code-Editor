document.getElementById('signupForm').addEventListener('submit', function (event) {
    event.preventDefault(); 

    const nameInput = document.getElementById('name');
    const passwordInput = document.getElementById('password');
    const name = nameInput.value.trim();
    const password = passwordInput.value.trim();

    clearErrors();

    let isValid = true;


    if (name === '') {
        showError(nameInput, 'Username is required.');
        isValid = false;
    } else if (name.length < 3) {
        showError(nameInput, 'Username must be at least 3 characters long.');
        isValid = false;
    }

  
    if (password === '') {
        showError(passwordInput, 'Password is required.');
        isValid = false;
    } else if (password.length < 6) {
        showError(passwordInput, 'Password must be at least 6 characters long.');
        isValid = false;
    }

    
    if (isValid) {
        alert('Form submitted successfully!');
        
        event.target.submit(); 
    }
});

function showError(input, message) {
    const parent = input.parentElement;
    const error = document.createElement('small');
    error.textContent = message;
    error.style.color = 'red';
    error.style.display = 'block';
    parent.appendChild(error);
}


function clearErrors() {
    const errors = document.querySelectorAll('small');
    errors.forEach(error => error.remove());
}


document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const eyeIcon = this.querySelector('.eye-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('closed-eye');
        eyeIcon.classList.add('open-eye');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('open-eye');
        eyeIcon.classList.add('closed-eye');
    }
});
