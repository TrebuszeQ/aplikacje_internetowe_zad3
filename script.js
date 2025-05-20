let carousel = undefined;
let carousel_position = 0;
let carousel_length = 0;
let carousel_unit = 0;

function register_carousel_data(length, unit) {
    console.log("Registering carousel data")
    carousel_length = length;
    carousel_unit = unit;
}

function register_carousel_element(carousel_id) {
    // console.log(carousel_id);
    carousel = document.getElementById(carousel_id);
}

function carousel_move(carousel_id, move_by) {
    console.log(`Moving carousel`);
    // console.log(carousel);
    
    if (carousel == null) {
        register_carousel_element(carousel_id);
    }

    position = carousel_position - move_by;
    min = ((carousel_length -1) * -carousel_unit);
    console.log(min);
    if (position < min) {
        position = 0;
    }
    else if (position > 0) {
        position = min;
    }
    
    carousel_position = position;
    console.log(carousel_position);

    if (carousel) {
        carousel.animate(
            [
                {
                    transform: `translateX(${position}vw)`,
                    easing: "ease-out"
                }
            ],
            { 
                fill: "forwards", 
                duration: 1500 
            }
        );
        console.log(`Carousel moved by ${move_by}vw to ${position}`);
    }
}