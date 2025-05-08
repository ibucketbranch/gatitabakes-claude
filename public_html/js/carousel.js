document.addEventListener('DOMContentLoaded', function() {
    let currentSlide = 0;
    const slides = document.querySelectorAll('.product-slide');
    const dots = document.querySelectorAll('.dot');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');

    function updateSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        
        // Update button states
        prevButton.disabled = index === 0;
        nextButton.disabled = index === slides.length - 1;
    }

    if (prevButton) {
        prevButton.addEventListener('click', () => {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlide(currentSlide);
            }
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', () => {
            if (currentSlide < slides.length - 1) {
                currentSlide++;
                updateSlide(currentSlide);
            }
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateSlide(currentSlide);
        });
    });

    // Initialize first slide
    updateSlide(currentSlide);
}); 