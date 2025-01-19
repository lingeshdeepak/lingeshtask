document.addEventListener('DOMContentLoaded', function () {
    const sliderContainer = document.querySelector('.slider-container');
    const slides = sliderContainer.children;
    const dotsContainer = document.querySelector('.slider-dots');

    // Add dots
    for (let i = 0; i < slides.length; i++) {
        const dot = document.createElement('button');
        dot.classList.add('dot');
        if (i === 0) dot.classList.add('active'); // Mark the first dot as active
        dot.addEventListener('click', () => {
            sliderContainer.scrollTo({
                left: i * sliderContainer.offsetWidth,
                behavior: 'smooth',
            });

            // Update active dot
            document.querySelectorAll('.dot').forEach((d) => d.classList.remove('active'));
            dot.classList.add('active');
        });
        dotsContainer.appendChild(dot);
    }

    // Update active dot on scroll
    sliderContainer.addEventListener('scroll', () => {
        const activeIndex = Math.round(sliderContainer.scrollLeft / sliderContainer.offsetWidth);
        document.querySelectorAll('.dot').forEach((d, index) => {
            d.classList.toggle('active', index === activeIndex);
        });
    });
});
