document.getElementById("contactForm").addEventListener("submit", function(event) {
    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const phoneNumber = document.getElementById("phoneNumber");
    const email = document.getElementById("email");
    const message = document.getElementById("message");

    const phonePattern = /^[0-9()+\-\s]+$/;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (
        firstName.value.trim() === "" ||
        lastName.value.trim() === "" ||
        phoneNumber.value.trim() === "" ||
        email.value.trim() === "" ||
        message.value.trim() === ""
    ) {
        alert("All fields are required. Please fill them out.");
        event.preventDefault();
        return;
    }

    if (!phonePattern.test(phoneNumber.value)) {
        alert("Please enter a valid phone number with numbers only.");
        event.preventDefault();
        return;
    }

    if (!emailPattern.test(email.value)) {
        alert("Please enter a valid email address.");
        event.preventDefault();
        return;
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const menua = document.querySelector('.menu');
    const navigationLinks = document.querySelector('.navigation-links');

    menua.addEventListener('click', function() {
        navigationLinks.classList.toggle('show');
 });
});