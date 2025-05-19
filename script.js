let carousel = undefined;
let carousel_position = 0;

function register_carousel(carousel_id) {
    console.log(carousel_id);
    carousel = document.getElementById(carousel_id);
}

function carousel_move(carousel_id, move_by) {
    console.log(`Moving carousel`);
    console.log(carousel);
    
    if (carousel == null) {
        register_carousel(carousel_id);
    }

    position = carousel_position - move_by;
    if (carousel) {
        carousel.animate(
            [
                {
                    transform: `translateX(${position}%)`,
                    easing: "ease-out"
                }
            ],
            { 
                fill: "forwards", 
                duration: 1500 
            }
        );
        console.log(`Carousel moved by ${move_by}% to ${position}`);
    }
}