const profil_left= document.querySelector(".profil-left ");
const profil_right= document.querySelector(".profil-right ");

window.addEventListener('load', () => {
    const TL = gsap.timeline({ paused: true });
    TL.
    staggerFrom(profil_left,1, { x: -300, opacity: 0, ease: "power2.out" },"-=1")
    .staggerFrom(profil_right,1, { x: 300, opacity: 0, ease: "power2.out" },"-=1")




    TL.play();
})

