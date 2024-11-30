document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (username === '') {
        alert('Username is required');
        return;
    }

    if (!validatePassword(password)) {
        alert('Password must be at least 8 characters long, include at least one uppercase letter, and contain at least one number.');
        return;
    }

    alert('Login successful!');
});


function validatePassword(password) {
    const passwordRegex = /^(?=.[A-Z])(?=.\d).{8,}$/;
    return passwordRegex.test(password);
}
