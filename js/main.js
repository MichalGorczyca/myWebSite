const leftBars = [...document.querySelectorAll(".content-left")];
const rightBars = [...document.querySelectorAll(".content-right")];

const animate = function () {

    
    leftBars.forEach(bar => {

        bar.style.left = "0";
        bar.style.transition = `left .4s`;

    })


    rightBars.forEach(bar => {

        bar.style.right = "0";
        bar.style.transition = `right .4s`;

    })

}
