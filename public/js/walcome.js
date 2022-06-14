const firstTitre = document.querySelectorAll(".text .h1 ");
const secoundTitre = document.querySelectorAll(".text .p");
const header = document.querySelector(".header");
const span1 = document.querySelector(".span1");
const span2 = document.querySelector(".span2");
const logo = document.querySelector(".image");
const commencez = document.querySelector(".commencez");

window.addEventListener('load', () => {
    const TL = gsap.timeline({ paused: true });
    TL.
    staggerFrom(header, 1, { top: -50, opacity: 0, ease: "power2.out" }, "-=1")
    .staggerFrom(firstTitre, 1, { top: -50, opacity: 0, ease: "power2.out" }, "-=1")
        .staggerFrom(secoundTitre, 1, { top: -50, opacity: 0, ease: "power2.out" }, "-=2")
        .staggerFrom(commencez, 1, { top: -50, opacity: 0, ease: "power2.out" }, "-=2")
        // .from(span1, 1.5, { transform: "scale(0)", ease: "power2.out" }, "-=3")
        // .from(span2, 1.5, { transform: "scale(0)", ease: "power2.out" }, "-=3")
        .from(logo , 1.5, { transform: "scale(0)",  ease: "power2.out" }, 2,"-=4")
        // .from(logo, 1.5, { transform: "scale(0)", ease: "power2.out" }, "-=2")


    TL.play();
})

