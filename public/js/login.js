const logo = document.querySelectorAll(".container .row img ");
const form = document.querySelectorAll(".container .row .col-md-4");


window.addEventListener('load', () => {
    const TL = gsap.timeline({ paused: true });
    TL.
    staggerFrom(logo, 1, { transform: "scale(0)", ease: "power2.out" }, "-=1")
        .from(form, 1.5, {  top: -50, opacity: 0, ease: "power2.out"  }, "-=2")



    TL.play();
})
