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
    const dropdown_menua = document.querySelector('.dropdown_menu');

    menua.addEventListener('click', function() {
        dropdown_menua.classList.toggle('show');
 });
  
    const slider = document.querySelector('.slider-wrapper');
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    
    let currentSlide = 0;
    const totalSlides = slides.length;

    console.log('Slider:', slider);
    console.log('Slides:', slides);
    console.log('Navigation buttons:', prevBtn, nextBtn);

    function updateSlider() {
        console.log('Moving to slide:', currentSlide);
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        dots.forEach(dot => dot.classList.remove('active'));
        dots[currentSlide].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlider();
    }


    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateSlider();
        });
    });
});