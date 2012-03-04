/* Author:
Édouard Lopez
*/

$(document).ready(function(){

    loginOpacityTest();
    placeWeatherIcon();
});


function placeWeatherIcon()
{
    $('#authentification .time-indicator .now').css({
        backgroundPosition: getWeatherIconPosition()*100+'% '+getWeatherIconPosition()*100+'%'
    });
}

function getWeatherIconPosition()
{
    var currentTime = new Date()
    currentTimeAsMin = currentTime.getHours()*60+currentTime.getMinutes();
    result = Math.round(currentTimeAsMin / (24*60) * 100)/100; // day progession in percent (e.g. 0.75)
    console.log(result);

    return result;
}

function loginOpacityTest() {
    $('#authentification > aside').toggle(
        function () {
            $('#authentification .time-indicator').animate({
                opacity: 0.25,
                backgroundPosition: ('80%', '20%')
            }, {
                duration: 2000,
                step: function( now, fx ){
                    $( ".block:gt(0)" ).css( "left", now );
                }
            });
        },
        function () {
            $('#authentification .time-indicator').animate({
                opacity: 1,
                backgroundPosition: ('0%', '100%')
            }, {
                duration: 2000,
                step: function( now, fx ){
                    $( ".block:gt(0)" ).css( "left", now );
                }
            });
        }
    );

}