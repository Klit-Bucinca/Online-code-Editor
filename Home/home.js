document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault();

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

    const formData = new FormData(this);

    fetch('contact_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') {
 
            this.reset();
        }
    })
    .catch(error => {
        alert('An error occurred while submitting the form.');
        console.error('Error:', error);
    });
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

document.getElementById("sliderForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const title = document.querySelector('input[name="title"]');
    const description = document.querySelector('textarea[name="description"]');
    const image = document.querySelector('input[name="image"]');

    if (
        title.value.trim() === "" ||
        description.value.trim() === "" ||
        !image.files[0]
    ) {
        alert("All fields are required. Please fill them out.");
        return;
    }

    const formData = new FormData(this);

    fetch('add_slide.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') {
            this.reset();
            location.reload(); 
        }
    })
    .catch(error => {
        alert('An error occurred while adding the slide.');
        console.error('Error:', error);
    });
});

document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('delete-slide')) {
        if (confirm('Are you sure you want to delete this slide?')) {
            const slideId = e.target.dataset.id;
            const formData = new FormData();
            formData.append('id', slideId);

            fetch('delete_slide.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    location.reload(); 
                }
            })
            .catch(error => {
                alert('An error occurred while deleting the slide.');
                console.error('Error:', error);
            });
        }
    }
});