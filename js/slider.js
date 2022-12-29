// SLIDER 
let slider = tns({
    container: '.intro-list',
    mode:"gallery",
    items: 1,
    mouseDrag: true,
    autoplay: true,
    controls: false,
    navContainer: '.slider-nav',
    autoplayButtonOutput: false,
    autoplayTimeout: 5000,
});

let team = tns({
    container: '.team-photo',
    items: 1,
    mouseDrag: true,
    mode:"gallery",
    // gutter: '20px',
    slideBy: 1,
    autoplay: true,
    // lazyload: true,
    // controls: false,
    navContainer: '.nav-team',
    autoplayButtonOutput: false,
    controlsContainer: '.controls-team',
});