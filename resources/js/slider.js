let counter = 0;

document.addEventListener("DOMContentLoaded", () => {

    const slider = document.getElementById("slider");

    if (!slider) return;

    const images = document.querySelectorAll("#slider img");
    const dots = document.querySelectorAll(".dot");

    function updateSlider() {
        slider.style.transform = `translateX(-${counter * 100}%)`;

        dots.forEach((dot, index) => {
            dot.classList.toggle("bg-white", index === counter);
            dot.classList.toggle("bg-white/50", index !== counter);
        });
    }

    window.moveSlide = function(step) {

        counter += step;

        if (counter >= images.length) counter = 0;
        if (counter < 0) counter = images.length - 1;

        updateSlider();
    };

    dots.forEach((dot, index) => {

        dot.addEventListener("click", () => {
            counter = index;
            updateSlider();
        });

    });

    setInterval(() => {
        moveSlide(1);
    }, 3000);

    updateSlider();

});
