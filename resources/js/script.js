/* Author:
Édouard Lopez
*/

$(document).ready(function(){
    $('#authentification').toggle(
        function () {
            $(this).animate({
                opacity: 0.25,
                backgroundPosition: '100% 50%' // doesn't work
            }, 2000);
        },
        function () {
            $(this).animate({
                opacity: 1,
                backgroundPosition: '80% 25%' // doesn't work
            }, 2000);
        }
    );
});
